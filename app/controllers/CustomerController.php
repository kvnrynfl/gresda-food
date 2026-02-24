<?php

class CustomerController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
            $this->redirect('/auth/login');
        }
    }

    public function index() {
        $data['user'] = $this->model('UserModel')->findUserByEmail($_SESSION['email']);
        
        $orderModel = $this->model('OrderModel');
        $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
        $data['cart_count'] = count($cartItems);
        
        // Pass all carts as recent orders for now, will filter in view or model
        $data['recent_orders'] = $orderModel->getOrdersByUser($_SESSION['user_id']);

        $this->view('customer/profile', $data);
    }

    public function cart() {
        $orderModel = $this->model('OrderModel');
        $data['cart_items'] = $orderModel->getCartItemsByUser($_SESSION['user_id']);
        $this->view('customer/cart', $data);
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $foodId = Sanitize::string($_POST['food_id']);
            $orderModel = $this->model('OrderModel');
            
            $orderModel->addToCart($_SESSION['user_id'], $foodId, 1);
            
            $_SESSION['flash_success'] = "Berhasil masuk keranjang!";
            $this->redirect('/menu');
        }
    }

    public function updateCartQty() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $foodId = Sanitize::string($_POST['food_id']);
            $action = Sanitize::string($_POST['action']);
            
            $orderModel = $this->model('OrderModel');
            $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
            
            foreach ($cartItems as $item) {
                if ($item['food_id'] == $foodId) {
                    $currentQty = $item['qty'];
                    if ($action == 'increase') {
                        $orderModel->updateCartQty($item['detail_id'], $currentQty + 1);
                    } elseif ($action == 'decrease' && $currentQty > 1) {
                        $orderModel->updateCartQty($item['detail_id'], $currentQty - 1);
                    }
                    break;
                }
            }
            $this->redirect('/customer/cart');
        }
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $foodId = Sanitize::string($_POST['food_id']);
            $orderModel = $this->model('OrderModel');
            $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
            
            foreach ($cartItems as $item) {
                if ($item['food_id'] == $foodId) {
                    $orderModel->removeCartItem($item['detail_id']);
                    break;
                }
            }
            $this->redirect('/customer/cart');
        }
    }

    public function checkoutSelected() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            if (!isset($_POST['selected_items']) || empty($_POST['selected_items'])) {
                $_SESSION['flash_error'] = "Pilih setidaknya satu item untuk di-checkout.";
                $this->redirect('/customer/cart');
                return;
            }
            $_SESSION['checkout_items'] = $_POST['selected_items'];
            $this->redirect('/customer/checkout');
        }
    }

    public function checkout() {
        if (!isset($_SESSION['checkout_items']) || empty($_SESSION['checkout_items'])) {
            $_SESSION['flash_error'] = "Anda belum memilih item untuk dibayar.";
            $this->redirect('/customer/cart');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $data['payment_methods'] = $orderModel->getAllPayments();
        
        $allItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
        $checkoutItems = [];
        foreach ($allItems as $item) {
            if (in_array($item['detail_id'], $_SESSION['checkout_items'])) {
                $checkoutItems[] = $item;
            }
        }
        $data['checkout_items'] = $checkoutItems;
        
        if (empty($checkoutItems)) {
            $this->redirect('/customer/cart');
        } else {
            $this->view('customer/checkout', $data);
        }
    }

    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            if (!isset($_SESSION['checkout_items']) || empty($_SESSION['checkout_items'])) {
                $this->redirect('/customer/cart');
                return;
            }
            $orderModel = $this->model('OrderModel');
            
            $allItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
            $checkoutItems = [];
            foreach ($allItems as $item) {
                if (in_array($item['detail_id'], $_SESSION['checkout_items'])) {
                    $checkoutItems[] = $item;
                }
            }
            
            if (empty($checkoutItems)) {
                 $this->redirect('/customer/cart');
                 return;
            }

            // Determine Totals
            $totalPrice = 0;
            foreach ($checkoutItems as $item) {
                $totalPrice += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
            }
            // Calculate Grand Total including Tax (10%) and Shipping (15000)
            $grandTotal = ($totalPrice * 1.1) + 15000;
            
            // Create the real Order Document
            $orderId = uniqid('ORD-');
            $orderModel->createOrder($orderId, $_SESSION['user_id'], $grandTotal, 'Payment');

            // Move the selected items from the cart to order_details
            foreach ($checkoutItems as $item) {
                $orderModel->addDetailItem($orderId, $item['food_id'], $item['qty'], $item['price'] ?? 0);
                $orderModel->removeCartItem($item['detail_id']);
            }

            // Add to tbl_confirmorder (Image will be uploaded later in payment flow)
            $confirmData = [
                'order_id' => $orderId,
                'user_id' => $_SESSION['user_id'],
                'payment' => Sanitize::string($_POST['payment_method']),
                'rekening_name' => Sanitize::string($_POST['rekening_name']),
                'image_name' => '', // Empty until they upload proof
                'alamat' => Sanitize::string($_POST['address']),
                'tgl_pay' => date('Y-m-d') // Will update this accurately when they upload
            ];
            $orderModel->saveConfirmOrder($confirmData);
            
            // clear session selection
            unset($_SESSION['checkout_items']);

            $_SESSION['flash_success'] = "Pesanan berhasil dibuat. Silakan unggah bukti pembayaran Anda.";
            
            $this->redirect('/customer/orders');
        }
    }

    public function orders() {
        $data['orders'] = $this->model('OrderModel')->getOrdersByUser($_SESSION['user_id']); 
        $this->view('customer/orders', $data);
    }
    
    public function orderDetails($id) {
        $orderModel = $this->model('OrderModel');
        
        $userOrders = $orderModel->getOrdersByUser($_SESSION['user_id']);
        $isOwner = false;
        $activeOrder = null;
        foreach($userOrders as $order) {
            if($order['order_id'] == $id) {
                $isOwner = true;
                $activeOrder = $order;
                break;
            }
        }
        
        if(!$isOwner) {
            $this->redirect('/customer/orders');
            return;
        }

        $data['order'] = $activeOrder;
        $data['details'] = $orderModel->getOrderDetails($id);
        $data['confirm'] = $orderModel->getConfirmOrder($id);
        $data['order_id'] = $id;
        $this->view('customer/order_details', $data);
    }

    public function payment($id) {
        $orderModel = $this->model('OrderModel');
        
        // Security check: Verify order belongs to this user
        $userOrders = $orderModel->getOrdersByUser($_SESSION['user_id']);
        $isOwner = false;
        $activeOrder = null;
        foreach($userOrders as $order) {
            if($order['order_id'] == $id) {
                $isOwner = true;
                $activeOrder = $order;
                break;
            }
        }
        
        if(!$isOwner || $activeOrder['status'] !== 'Payment') {
            $this->redirect('/customer/orders');
            return;
        }

        $data['order'] = $activeOrder;
        $data['order_id'] = $id;
        $this->view('customer/payment', $data);
    }

    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $orderId = $_POST['order_id'] ?? '';
            
            if (empty($orderId)) {
                $this->redirect('/customer/orders');
                return;
            }

            // Verify Ownership
            $orderModel = $this->model('OrderModel');
            $userOrders = $orderModel->getOrdersByUser($_SESSION['user_id']);
            $isOwner = false;
            foreach($userOrders as $order) {
                if($order['order_id'] == $orderId) {
                    $isOwner = true;
                    break;
                }
            }
            
            if(!$isOwner) {
                $this->redirect('/customer/orders');
                return;
            }

            // Handle file upload for payment proof
            if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
                $upload = Upload::image($_FILES['payment_proof'], '../public/images/confirm');
                if ($upload['status']) {
                    $image_name = $upload['filename'];
                    
                    // Update tbl_confirmorder
                    $orderModel->updateConfirmOrderImage($orderId, $image_name, date('Y-m-d'));
                    
                    // Update order status to Confirmed so it moves to the next stage
                    $orderModel->updateOrderStatus($orderId, 'Confirmed');
                    
                    $_SESSION['flash_success'] = "Bukti pembayaran berhasil diunggah. Kami akan segera memverifikasinya.";
                } else {
                    $_SESSION['flash_error'] = "Gagal mengunggah bukti pembayaran: " . $upload['message'];
                    $this->redirect('/customer/payment/' . $orderId);
                    return;
                }
            } else {
                $_SESSION['flash_error'] = "Bukti pembayaran wajib diunggah.";
                $this->redirect('/customer/payment/' . $orderId);
                return;
            }

            $this->redirect('/customer/orderDetails/' . urlencode($orderId));
        }
    }

    public function changePassword() {
        $this->view('customer/change_password');
    }

    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $userModel = $this->model('UserModel');
            $user = $userModel->findUserByEmail($_SESSION['email']);
            
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            
            if ($newPassword === $confirmPassword) {
                // Verify old password (supporting both bcrypt and legacy SHA1)
                $isValid = password_verify($oldPassword, $user['password']) || (sha1($oldPassword) === $user['password']);
                if ($isValid) {
                    $hashedNew = password_hash($newPassword, PASSWORD_BCRYPT);
                    $userModel->updatePassword($user['id'], $hashedNew);
                    $_SESSION['flash_success'] = "Kata sandi berhasil diperbarui.";
                } else {
                    $_SESSION['flash_error'] = "Kata sandi lama salah.";
                }
            } else {
                $_SESSION['flash_error'] = "Konfirmasi kata sandi tidak cocok.";
            }
            $this->redirect('/customer/profile');
        }
    }

    public function editProfile() {
        $data['user'] = $this->model('UserModel')->findUserByEmail($_SESSION['email']);
        $this->view('customer/edit_profile', $data); 
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $data = Sanitize::array($_POST);
            $userModel = $this->model('UserModel');
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload = Upload::image($_FILES['image'], '../public/images/users');
                if ($upload['status']) {
                    $data['img_user'] = $upload['filename'];
                } else {
                    $_SESSION['flash_error'] = "Gagal mengunggah foto: " . $upload['message'];
                    $this->redirect('/customer/editProfile');
                    return;
                }
            }
            
            $userModel->updateProfile($_SESSION['user_id'], $data);
            $_SESSION['username'] = $data['username']; // Update session
            $_SESSION['email'] = $data['email'];
            
            $_SESSION['flash_success'] = "Profil berhasil diperbarui.";
            $this->redirect('/customer/profile');
        }
    }

    public function reviews() {
        $this->view('customer/reviews');
    }

    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $data = Sanitize::array($_POST);
            $data['user_id'] = $_SESSION['user_id'];
            $data['active'] = 'Pending';
            
            $this->model('ReviewModel')->create($data);
            $this->redirect('/customer/orders');
        }
    }
}
