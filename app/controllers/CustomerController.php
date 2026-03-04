<?php

/**
 * Customer Controller
 * 
 * Handles all customer-facing features:
 * - Cart (add, update qty, remove, checkout selected)
 * - Checkout & Payment
 * - Orders & Order Details
 * - Profile & Edit Profile
 * - Change Password
 * - Reviews
 */
class CustomerController extends Controller
{
    private function checkAuth()
    {
        $this->requireLogin();
    }

    // ═══════════════════════════════════════════════════════════════
    // CART
    // ═══════════════════════════════════════════════════════════════

    public function cart()
    {
        $this->checkAuth();
        $orderModel = $this->model('OrderModel');

        $this->view('customer/cart', [
            'cart_items' => $orderModel->getCartItemsByUser($_SESSION['user_id']),
        ]);
    }

    /**
     * Add item to cart — supports both AJAX (JSON) and normal form POST
     */
    public function addToCart()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/menu');
            return;
        }

        // CSRF check — skip for AJAX if token sent via form data
        if (!empty($_POST['csrf_token']) && !CSRF::verifyToken($_POST['csrf_token'])) {
            if ($this->isAjax()) {
                $this->json(['status' => 'error', 'message' => 'Token keamanan tidak valid.']);
                return;
            }
            $this->redirect('/menu');
            return;
        }

        $foodId = $_POST['food_id'] ?? '';
        $qty = max(1, (int)($_POST['qty'] ?? 1));

        if (empty($foodId)) {
            if ($this->isAjax()) {
                $this->json(['status' => 'error', 'message' => 'ID makanan tidak valid.']);
                return;
            }
            $this->redirect('/menu');
            return;
        }

        // Verify food exists and is active
        $foodModel = $this->model('FoodModel');
        $food = $foodModel->getById($foodId);
        if (!$food || !$food['is_active']) {
            if ($this->isAjax()) {
                $this->json(['status' => 'error', 'message' => 'Menu tidak tersedia.']);
                return;
            }
            $this->redirect('/menu');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $orderModel->addToCart($_SESSION['user_id'], $foodId, $qty);

        // Return JSON for AJAX requests (from menu page)
        if ($this->isAjax()) {
            $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
            $this->json([
                'status' => 'success',
                'message' => $food['name'] . ' ditambahkan ke keranjang!',
                'cart_count' => count($cartItems),
            ]);
            return;
        }

        $this->flash('success', 'Menu berhasil ditambahkan ke keranjang.');
        $this->redirect('/customer/cart');
    }

    /**
     * Update cart item quantity (increase/decrease)
     */
    public function updateCartQty()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/cart');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/cart');
            return;
        }

        $foodId = $_POST['food_id'] ?? '';
        $action = $_POST['action'] ?? '';

        if (empty($foodId)) {
            $this->redirect('/customer/cart');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);

        // Find the cart item by food_id
        foreach ($cartItems as $item) {
            if ($item['food_id'] === $foodId) {
                $newQty = $item['qty'];
                if ($action === 'increase') {
                    $newQty++;
                } elseif ($action === 'decrease' && $newQty > 1) {
                    $newQty--;
                }
                $orderModel->updateCartQty($item['detail_id'], $newQty);
                break;
            }
        }

        $this->redirect('/customer/cart');
    }

    /**
     * Remove item from cart by food_id
     */
    public function removeFromCart()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/cart');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/cart');
            return;
        }

        $foodId = $_POST['food_id'] ?? '';

        if (empty($foodId)) {
            $this->redirect('/customer/cart');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);

        // Find the cart item by food_id and remove it
        foreach ($cartItems as $item) {
            if ($item['food_id'] === $foodId) {
                $orderModel->removeCartItem($item['detail_id']);
                break;
            }
        }

        $this->flash('success', 'Item berhasil dihapus dari keranjang.');
        $this->redirect('/customer/cart');
    }

    /**
     * Remove cart item by detail ID (direct)
     */
    public function removeCart($detailId = '')
    {
        $this->checkAuth();

        if (empty($detailId)) {
            $this->redirect('/customer/cart');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $orderModel->removeCartItem($detailId);

        $this->flash('success', 'Item berhasil dihapus dari keranjang.');
        $this->redirect('/customer/cart');
    }

    /**
     * Legacy updateCart method (by detail_id)
     */
    public function updateCart()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/cart');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/cart');
            return;
        }

        $detailId = $_POST['detail_id'] ?? '';
        $qty = max(1, (int)($_POST['qty'] ?? 1));

        if (!empty($detailId)) {
            $orderModel = $this->model('OrderModel');
            $orderModel->updateCartQty($detailId, $qty);
        }

        $this->redirect('/customer/cart');
    }

    // ═══════════════════════════════════════════════════════════════
    // CHECKOUT
    // ═══════════════════════════════════════════════════════════════

    /**
     * Checkout selected items from cart
     * POST from cart page with selected_items[] array
     */
    public function checkoutSelected()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/cart');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/cart');
            return;
        }

        $selectedIds = $_POST['selected_items'] ?? [];

        if (empty($selectedIds)) {
            $this->flash('error', 'Pilih minimal satu item untuk checkout.');
            $this->redirect('/customer/cart');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $userModel = $this->model('UserModel');
        $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
        $user = $userModel->findById($_SESSION['user_id']);

        // Filter only selected items
        $checkoutItems = [];
        foreach ($cartItems as $item) {
            if (in_array($item['id'], $selectedIds)) {
                $checkoutItems[] = $item;
            }
        }

        if (empty($checkoutItems)) {
            $this->flash('error', 'Item yang dipilih tidak valid.');
            $this->redirect('/customer/cart');
            return;
        }

        // Store selected items in session for checkout page
        $_SESSION['checkout_items'] = $checkoutItems;

        // Get payment methods
        $paymentMethods = $orderModel->getAllPaymentMethods();

        $subtotal = 0;
        foreach ($checkoutItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $taxRate = 0.10;
        $taxAmount = $subtotal * $taxRate;
        $shippingCost = 15000;
        $grandTotal = $subtotal + $taxAmount + $shippingCost;

        $this->view('customer/checkout', [
            'checkout_items' => $checkoutItems,
            'payment_methods' => $paymentMethods,
            'user' => $user,
            'subtotal' => $subtotal,
            'taxAmount' => $taxAmount,
            'shippingCost' => $shippingCost,
            'grandTotal' => $grandTotal,
        ]);
    }

    /**
     * Legacy checkout (all cart items)
     */
    public function checkout()
    {
        $this->checkAuth();
        $orderModel = $this->model('OrderModel');
        $userModel = $this->model('UserModel');

        $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
        $user = $userModel->findById($_SESSION['user_id']);

        if (empty($cartItems)) {
            $this->flash('error', 'Keranjang belanja Anda kosong.');
            $this->redirect('/customer/cart');
            return;
        }

        $paymentMethods = $orderModel->getAllPaymentMethods();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $taxRate = 0.10;
        $taxAmount = $subtotal * $taxRate;
        $shippingCost = 15000;
        $grandTotal = $subtotal + $taxAmount + $shippingCost;

        $this->view('customer/checkout', [
            'checkout_items' => $cartItems,
            'payment_methods' => $paymentMethods,
            'user' => $user,
            'subtotal' => $subtotal,
            'taxAmount' => $taxAmount,
            'shippingCost' => $shippingCost,
            'grandTotal' => $grandTotal,
        ]);
    }

    public function processCheckout()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/cart');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/cart');
            return;
        }

        $_POST = Sanitize::array($_POST);

        $orderModel = $this->model('OrderModel');

        // Use session checkout items if available, otherwise fall back to all cart items
        $checkoutItems = $_SESSION['checkout_items'] ?? null;
        if (empty($checkoutItems)) {
            $checkoutItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);
        }

        if (empty($checkoutItems)) {
            $this->redirect('/customer/cart');
            return;
        }

        $subtotal = 0;
        foreach ($checkoutItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $taxAmount = $subtotal * 0.10;
        $shippingCost = 15000;
        $grandTotal = $subtotal + $taxAmount + $shippingCost;
        $address = $_POST['shipping_address'] ?? '';
        $notes = $_POST['notes'] ?? null;

        if (empty($address)) {
            $this->flash('error', 'Alamat pengiriman wajib diisi.');
            $this->redirect('/customer/checkout');
            return;
        }

        // Use transaction for atomicity
        $db = new Database();
        $db->beginTransaction();

        try {
            // Create order
            $orderId = $orderModel->createOrder(
                $_SESSION['user_id'], $subtotal, $taxAmount, $shippingCost, $grandTotal, $address, $notes
            );

            // Move checkout items to order details
            foreach ($checkoutItems as $item) {
                $orderModel->addDetailItem($orderId, $item['food_id'], $item['name'], $item['qty'], $item['price']);
            }

            // Remove checkout items from cart
            foreach ($checkoutItems as $item) {
                $orderModel->removeCartItem($item['detail_id']);
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
            error_log("Checkout failed: " . $e->getMessage());
            $this->flash('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
            $this->redirect('/customer/cart');
            return;
        }

        // Clean up session checkout items
        unset($_SESSION['checkout_items']);

        $this->flash('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        $this->redirect('/customer/payment/' . $orderId);
    }

    // ═══════════════════════════════════════════════════════════════
    // PAYMENT
    // ═══════════════════════════════════════════════════════════════

    public function payment($orderId = '')
    {
        $this->checkAuth();

        if (empty($orderId)) {
            $this->redirect('/customer/orders');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderByIdAndUser($orderId, $_SESSION['user_id']);

        if (!$order) {
            $this->show404();
            return;
        }

        $paymentMethods = $orderModel->getAllPaymentMethods();
        $existingPayment = $orderModel->getPaymentConfirmation($orderId);

        // Get primary payment info for display
        $paymentInfo = !empty($paymentMethods) ? $paymentMethods[0] : null;

        $this->view('customer/payment', [
            'order' => $order,
            'order_id' => $orderId,
            'payment_info' => $paymentInfo,
            'paymentMethods' => $paymentMethods,
            'existingPayment' => $existingPayment,
        ]);
    }

    public function processPayment()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/orders');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/orders');
            return;
        }

        $_POST = Sanitize::array($_POST);

        $orderId = $_POST['order_id'] ?? '';
        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderByIdAndUser($orderId, $_SESSION['user_id']);

        if (!$order || $order['status'] !== 'pending_payment') {
            $this->redirect('/customer/orders');
            return;
        }

        // Handle proof image upload
        $proofImage = null;
        if (isset($_FILES['proof_image']) && $_FILES['proof_image']['error'] === UPLOAD_ERR_OK) {
            $proofImage = Upload::image($_FILES['proof_image'], 'payment');
        }

        if (!$proofImage) {
            $this->flash('error', 'Bukti pembayaran wajib diunggah.');
            $this->redirect('/customer/payment/' . $orderId);
            return;
        }

        $orderModel->savePaymentConfirmation([
            'order_id' => $orderId,
            'user_id' => $_SESSION['user_id'],
            'payment_method_id' => $_POST['payment_method_id'] ?? null,
            'sender_name' => $_POST['sender_name'],
            'sender_account' => $_POST['sender_account'] ?? '',
            'amount' => (float)($order['grand_total'] ?? 0),
            'proof_image' => $proofImage,
            'payment_date' => $_POST['payment_date'] ?? date('Y-m-d'),
        ]);

        // Update order status to confirmed
        $orderModel->updateOrderStatus($orderId, 'confirmed');

        $this->flash('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
        $this->redirect('/customer/orderDetails/' . $orderId);
    }

    // ═══════════════════════════════════════════════════════════════
    // ORDERS
    // ═══════════════════════════════════════════════════════════════

    public function orders()
    {
        $this->checkAuth();
        $orderModel = $this->model('OrderModel');

        $this->view('customer/orders', [
            'orders' => $orderModel->getOrdersByUser($_SESSION['user_id']),
        ]);
    }

    public function orderDetails($orderId = '')
    {
        $this->checkAuth();

        if (empty($orderId)) {
            $this->show404();
            return;
        }

        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderByIdAndUser($orderId, $_SESSION['user_id']);

        if (!$order) {
            $this->show404();
            return;
        }

        $details = $orderModel->getOrderDetails($orderId);
        $payment = $orderModel->getPaymentConfirmation($orderId);

        $this->view('customer/order_details', [
            'order' => $order,
            'details' => $details,
            'payment' => $payment,
        ]);
    }

    public function cancelOrder($orderId = '')
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($orderId)) {
            $this->redirect('/customer/orders');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/orders');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderByIdAndUser($orderId, $_SESSION['user_id']);

        if (!$order || !in_array($order['status'], ['pending_payment'])) {
            $this->redirect('/customer/orders');
            return;
        }

        $reason = Sanitize::string($_POST['reason'] ?? 'Dibatalkan oleh pelanggan');
        $orderModel->cancelOrder($orderId, $reason);

        $this->flash('success', 'Pesanan berhasil dibatalkan.');
        $this->redirect('/customer/orders');
    }

    // ═══════════════════════════════════════════════════════════════
    // PROFILE
    // ═══════════════════════════════════════════════════════════════

    public function profile()
    {
        $this->checkAuth();
        $userModel = $this->model('UserModel');
        $orderModel = $this->model('OrderModel');

        $user = $userModel->findById($_SESSION['user_id']);
        $recentOrders = $orderModel->getOrdersByUser($_SESSION['user_id']);
        $cartItems = $orderModel->getCartItemsByUser($_SESSION['user_id']);

        $this->view('customer/profile', [
            'user' => $user,
            'recent_orders' => $recentOrders,
            'cart_count' => count($cartItems),
            'error' => '',
            'success' => $this->getFlash('success'),
        ]);
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $this->checkAuth();
        $userModel = $this->model('UserModel');
        $user = $userModel->findById($_SESSION['user_id']);

        $this->view('customer/account_settings', [
            'user' => $user,
            'error' => $this->getFlash('error'),
            'success' => $this->getFlash('success'),
        ]);
    }

    public function updateProfile()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/editProfile');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/editProfile');
            return;
        }

        $_POST = Sanitize::array($_POST);
        $userModel = $this->model('UserModel');

        // Email conflict check (exclude current user)
        if ($userModel->emailExists($_POST['email'], $_SESSION['user_id'])) {
            $user = $userModel->findById($_SESSION['user_id']);
            $this->view('customer/account_settings', ['user' => $user, 'error' => 'Email sudah digunakan akun lain.', 'success' => '']);
            return;
        }

        // Username conflict check
        if ($userModel->usernameExists($_POST['username'], $_SESSION['user_id'])) {
            $user = $userModel->findById($_SESSION['user_id']);
            $this->view('customer/account_settings', ['user' => $user, 'error' => 'Username sudah digunakan akun lain.', 'success' => '']);
            return;
        }

        $data = [
            'full_name' => $_POST['full_name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'] ?? null,
            'address' => $_POST['address'] ?? null,
        ];

        // Handle profile image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $data['img_user'] = Upload::image($_FILES['image'], 'users');
        }

        $userModel->updateProfile($_SESSION['user_id'], $data);

        // Update session
        $_SESSION['full_name'] = $data['full_name'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        if (isset($data['img_user'])) {
            $_SESSION['img_user'] = $data['img_user'];
        }

        $this->flash('success', 'Profil berhasil diperbarui.');
        $this->redirect('/customer/editProfile');
    }

    /**
     * Show change password form
     */
    public function changePassword()
    {
        $this->checkAuth();

        // If POST, process the password change
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updatePassword();
            return;
        }

        // GET — show the form
        $userModel = $this->model('UserModel');
        $user = $userModel->findById($_SESSION['user_id']);

        $this->view('customer/change_password', [
            'user' => $user,
            'error' => $this->getFlash('error'),
            'success' => $this->getFlash('success'),
        ]);
    }

    /**
     * Process password change
     */
    public function updatePassword()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/changePassword');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/changePassword');
            return;
        }

        $currentPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $userModel = $this->model('UserModel');
        $user = $userModel->findById($_SESSION['user_id']);

        if (!password_verify($currentPassword, $user['password'])) {
            $this->view('customer/change_password', ['user' => $user, 'error' => 'Kata sandi saat ini salah.', 'success' => '']);
            return;
        }

        if (strlen($newPassword) < 8) {
            $this->view('customer/change_password', ['user' => $user, 'error' => 'Kata sandi baru minimal 8 karakter.', 'success' => '']);
            return;
        }

        if ($newPassword !== $confirmPassword) {
            $this->view('customer/change_password', ['user' => $user, 'error' => 'Konfirmasi kata sandi tidak cocok.', 'success' => '']);
            return;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        $userModel->updatePassword($_SESSION['user_id'], $hashedPassword);

        // Clear remember token for security
        $userModel->setRememberToken($_SESSION['user_id'], null);

        $this->flash('success', 'Kata sandi berhasil diubah.');
        $this->redirect('/customer/changePassword');
    }

    // ═══════════════════════════════════════════════════════════════
    // REVIEWS
    // ═══════════════════════════════════════════════════════════════

    public function review()
    {
        $this->reviews();
    }

    public function reviews()
    {
        $this->checkAuth();

        $reviewModel = $this->model('ReviewModel');

        // Check if user already has a review
        $existingReview = $reviewModel->getByUserId($_SESSION['user_id']);

        $this->view('customer/reviews', [
            'existing_review' => $existingReview,
            'error' => $this->getFlash('error'),
            'success' => $this->getFlash('success'),
        ]);
    }

    public function submitReview()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/customer/reviews');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/customer/reviews');
            return;
        }

        $_POST = Sanitize::array($_POST);

        $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $message = trim($_POST['message'] ?? '');

        if (empty($message) || strlen($message) < 10) {
            $this->flash('error', 'Review minimal 10 karakter.');
            $this->redirect('/customer/reviews');
            return;
        }

        $orderModel = $this->model('OrderModel');
        $reviewModel = $this->model('ReviewModel');

        // Get the user's latest completed order for FK
        $orders = $orderModel->getOrdersByUser($_SESSION['user_id']);
        $completedOrder = null;
        foreach ($orders as $order) {
            if ($order['status'] === 'finished') {
                $completedOrder = $order;
                break;
            }
        }

        if (!$completedOrder) {
            $this->flash('error', 'Anda perlu memiliki pesanan selesai untuk memberikan review.');
            $this->redirect('/customer/orders');
            return;
        }

        $reviewModel->create([
            'user_id' => $_SESSION['user_id'],
            'order_id' => $completedOrder['id'],
            'rating' => $rating,
            'title' => $_POST['title'] ?? null,
            'message' => $message,
        ]);

        $this->flash('success', 'Terima kasih! Review Anda akan ditampilkan setelah disetujui admin.');
        $this->redirect('/customer/reviews');
    }

    // ═══════════════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════════════

    /**
     * Check if the current request is an AJAX request
     */
    private function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
