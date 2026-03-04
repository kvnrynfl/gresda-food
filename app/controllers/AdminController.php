<?php

/**
 * Admin Controller
 * 
 * Complete rewrite matching all admin view routes:
 * - Dashboard
 * - Categories (CRUD + detail)
 * - Foods (CRUD + detail)
 * - Orders (list + detail + status update + payment verify)
 * - Users/Clients (list + detail + delete)
 * - Admins (CRUD + password + detail)
 * - Reviews (list + detail + status)
 * - Contacts (list + detail + delete)
 */
class AdminController extends Controller
{
    /**
     * Check admin access for every method call
     */
    private function checkAdmin()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/auth/login');
        }
    }

    /**
     * Set admin flash message (uses flash_msg/flash_type for admin layout)
     */
    private function adminFlash($message, $type = 'success')
    {
        $_SESSION['flash_msg'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    // ═══════════════════════════════════════════════════════════════
    // DASHBOARD
    // ═══════════════════════════════════════════════════════════════

    public function dashboard()
    {
        $this->checkAdmin();

        $orderModel = $this->model('OrderModel');
        $userModel = $this->model('UserModel');
        $foodModel = $this->model('FoodModel');
        $contactModel = $this->model('ContactModel');

        $this->view('admin/dashboard', [
            'totalOrders' => count($orderModel->getAllOrders()),
            'totalRevenue' => $orderModel->getTotalRevenue(),
            'totalCustomers' => $userModel->countByRole('customer'),
            'totalFoods' => $foodModel->countActive(),
            'recentOrders' => $orderModel->getRecentOrders(5),
            'statusCounts' => $orderModel->getOrderStatusCounts(),
            'unreadContacts' => $contactModel->getUnreadCount(),
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    // CATEGORIES
    // ═══════════════════════════════════════════════════════════════

    public function categories()
    {
        $this->checkAdmin();
        $categoryModel = $this->model('CategoryModel');
        $this->view('admin/categories', [
            'categories' => $categoryModel->getAllWithFoodCount(),
        ]);
    }

    /**
     * Show category details
     */
    public function categoryDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $categoryModel = $this->model('CategoryModel');
        $category = $categoryModel->getById($id);

        if (!$category) {
            $this->show404();
        }

        $this->view('admin/category_details', ['category' => $category]);
    }

    /**
     * Show create category form (GET) or process creation (POST)
     */
    public function createCategory()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('admin/category_create');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/categories');
            return;
        }

        $_POST = Sanitize::array($_POST);

        $categoryModel = $this->model('CategoryModel');

        // Map view form fields to model fields
        $slug = $_POST['category'] ?? $_POST['slug'] ?? '';
        $isActive = ($_POST['active'] ?? 'Yes') === 'Yes' ? 1 : 0;

        $categoryModel->create([
            'name' => $_POST['name'],
            'slug' => $slug,
            'description' => $_POST['description'] ?? '',
            'icon' => $_POST['icon'] ?? '',
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
            'is_active' => $isActive,
        ]);

        $this->adminFlash('Kategori berhasil ditambahkan.');
        $this->redirect('/admin/categories');
    }

    /**
     * Show edit category form (GET) or process update (POST)
     */
    public function editCategory($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $categoryModel = $this->model('CategoryModel');
        $category = $categoryModel->getById($id);

        if (!$category) {
            $this->show404();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/categories');
                return;
            }

            $_POST = Sanitize::array($_POST);

            // Map view form fields to model fields
            $slug = $_POST['category'] ?? $_POST['slug'] ?? $category['slug'];
            $isActive = ($_POST['active'] ?? 'Yes') === 'Yes' ? 1 : 0;

            $categoryModel->update($id, [
                'name' => $_POST['name'],
                'slug' => $slug,
                'description' => $_POST['description'] ?? '',
                'icon' => $_POST['icon'] ?? '',
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'is_active' => $isActive,
            ]);

            $this->adminFlash('Kategori berhasil diperbarui.');
            $this->redirect('/admin/categories');
            return;
        }

        $this->view('admin/category_edit', ['category' => $category]);
    }

    /**
     * Legacy alias: addCategory → createCategory POST
     */
    public function addCategory()
    {
        $this->createCategory();
    }

    public function deleteCategory($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->redirect('/admin/categories');
            return;
        }

        $categoryModel = $this->model('CategoryModel');
        $categoryModel->delete($id);

        $this->adminFlash('Kategori berhasil dihapus.');
        $this->redirect('/admin/categories');
    }

    /**
     * Toggle category active status
     */
    public function toggleCategory($id = '')
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            $this->redirect('/admin/categories');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/categories');
            return;
        }

        $categoryModel = $this->model('CategoryModel');
        $categoryModel->toggleActive($id);

        $this->adminFlash('Status kategori berhasil diubah.');
        $this->redirect('/admin/categories');
    }

    // ═══════════════════════════════════════════════════════════════
    // FOOD ITEMS
    // ═══════════════════════════════════════════════════════════════

    public function foods()
    {
        $this->checkAdmin();
        $foodModel = $this->model('FoodModel');
        $categoryModel = $this->model('CategoryModel');

        $this->view('admin/foods', [
            'foods' => $foodModel->getAll(),
            'categories' => $categoryModel->getActive(),
        ]);
    }

    /**
     * Show food details
     */
    public function foodDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $foodModel = $this->model('FoodModel');
        $product = $foodModel->getById($id);

        if (!$product) {
            $this->show404();
        }

        $this->view('admin/food_details', ['product' => $product]);
    }

    /**
     * Show create food form (GET) or process creation (POST)
     */
    public function createFood()
    {
        $this->checkAdmin();
        
        $categoryModel = $this->model('CategoryModel');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('admin/food_create', ['categories' => $categoryModel->getActive()]);
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/foods');
            return;
        }

        $_POST = Sanitize::array($_POST);

        // Handle image upload
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = Upload::image($_FILES['image'], 'food');
        }

        $foodModel = $this->model('FoodModel');
        $foodModel->create([
            'category_id' => $_POST['category_id'],
            'name' => $_POST['name'],
            'price' => (float)$_POST['price'],
            'description' => $_POST['description'] ?? '',
            'image' => $image,
            'weight' => $_POST['weight'] ?? null,
            'is_bestseller' => isset($_POST['is_bestseller']) ? 1 : 0,
            'is_new' => isset($_POST['is_new']) ? 1 : 0,
            'is_spicy' => isset($_POST['is_spicy']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1,
        ]);

        $this->adminFlash('Menu berhasil ditambahkan.');
        $this->redirect('/admin/foods');
    }

    /**
     * Legacy alias: addFood → createFood
     */
    public function addFood()
    {
        $this->createFood();
    }

    /**
     * Show edit food form (GET) or process update (POST)
     */
    public function editFood($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $foodModel = $this->model('FoodModel');
        $categoryModel = $this->model('CategoryModel');
        $food = $foodModel->getById($id);

        if (!$food) {
            $this->show404();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/foods');
                return;
            }

            $_POST = Sanitize::array($_POST);

            $image = $food['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = Upload::image($_FILES['image'], 'food');
            }

            $foodModel->update($id, [
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'price' => (float)$_POST['price'],
                'description' => $_POST['description'] ?? '',
                'image' => $image,
                'weight' => $_POST['weight'] ?? null,
                'is_bestseller' => isset($_POST['is_bestseller']) ? 1 : 0,
                'is_new' => isset($_POST['is_new']) ? 1 : 0,
                'is_spicy' => isset($_POST['is_spicy']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1,
            ]);

            $this->adminFlash('Menu berhasil diperbarui.');
            $this->redirect('/admin/foods');
            return;
        }

        $this->view('admin/food_edit', [
            'product' => $food,
            'food' => $food,
            'categories' => $categoryModel->getActive(),
        ]);
    }

    public function deleteFood($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->redirect('/admin/foods');
            return;
        }

        $foodModel = $this->model('FoodModel');
        $foodModel->delete($id);

        $this->adminFlash('Menu berhasil dihapus.');
        $this->redirect('/admin/foods');
    }

    /**
     * Toggle food active status
     */
    public function toggleFood($id = '')
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            $this->redirect('/admin/foods');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/foods');
            return;
        }

        $foodModel = $this->model('FoodModel');
        $foodModel->toggleActive($id);

        $this->adminFlash('Status menu berhasil diubah.');
        $this->redirect('/admin/foods');
    }

    // ═══════════════════════════════════════════════════════════════
    // ORDERS
    // ═══════════════════════════════════════════════════════════════

    public function orders()
    {
        $this->checkAdmin();
        $orderModel = $this->model('OrderModel');

        $this->view('admin/orders', [
            'orders' => $orderModel->getAllOrders(),
        ]);
    }

    public function orderDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderById($id);

        if (!$order) {
            $this->show404();
        }

        $details = $orderModel->getOrderDetails($id);
        $payment = $orderModel->getPaymentConfirmation($id);

        $this->view('admin/order_details', [
            'order' => $order,
            'details' => $details,
            'payment' => $payment,
        ]);
    }

    public function updateOrderStatus($id = '')
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            $this->redirect('/admin/orders');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/orders');
            return;
        }

        $status = $_POST['status'] ?? '';
        $validStatuses = ['confirmed', 'processing', 'delivering', 'finished', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            $this->redirect('/admin/orders');
            return;
        }

        $orderModel = $this->model('OrderModel');

        if ($status === 'cancelled') {
            $orderModel->cancelOrder($id, $_POST['cancelled_reason'] ?? null);
        } else {
            $orderModel->updateOrderStatus($id, $status);
        }

        $this->adminFlash('Status pesanan berhasil diperbarui.');
        $this->redirect('/admin/orderDetails/' . $id);
    }

    public function verifyPayment($id = '')
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            $this->redirect('/admin/orders');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/orders');
            return;
        }

        $action = $_POST['action'] ?? '';
        $orderModel = $this->model('OrderModel');

        if ($action === 'verify') {
            $orderModel->updatePaymentStatus($id, 'verified', $_SESSION['user_id']);
            $this->adminFlash('Pembayaran berhasil diverifikasi.');
        } elseif ($action === 'reject') {
            $orderModel->updatePaymentStatus($id, 'rejected', $_SESSION['user_id'], $_POST['rejection_reason'] ?? '');
            $this->adminFlash('Pembayaran ditolak.');
        }

        $this->redirect('/admin/orders');
    }

    // ═══════════════════════════════════════════════════════════════
    // USERS / CLIENTS
    // ═══════════════════════════════════════════════════════════════

    /**
     * View route: admin/users — renders admin/users.php with $users variable
     */
    public function users()
    {
        $this->checkAdmin();
        $userModel = $this->model('UserModel');

        $this->view('admin/users', [
            'users' => $userModel->getAllCustomersWithOrderCount(),
        ]);
    }

    /**
     * Alias: admin/clients → admin/users
     */
    public function clients()
    {
        $this->users();
    }

    /**
     * View user/client details
     */
    public function userDetails($id = '')
    {
        $this->clientDetails($id);
    }

    public function clientDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $userModel = $this->model('UserModel');
        $client = $userModel->findById($id);

        if (!$client || $client['role'] !== 'customer') {
            $this->show404();
        }

        $orderModel = $this->model('OrderModel');

        $this->view('admin/user_details', [
            'client' => $client,
            'user' => $client,
            'orders' => $orderModel->getOrdersByUser($id),
        ]);
    }

    public function deleteClient($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->redirect('/admin/users');
            return;
        }

        $userModel = $this->model('UserModel');
        $userModel->delete($id);

        $this->adminFlash('Pelanggan berhasil dihapus.');
        $this->redirect('/admin/users');
    }

    // ═══════════════════════════════════════════════════════════════
    // ADMINS
    // ═══════════════════════════════════════════════════════════════

    public function admins()
    {
        $this->checkAdmin();
        $userModel = $this->model('UserModel');

        $this->view('admin/admins', [
            'admins' => $userModel->getAllAdmins(),
        ]);
    }

    /**
     * Show admin details
     */
    public function adminDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $userModel = $this->model('UserModel');
        $admin = $userModel->findById($id);

        if (!$admin || $admin['role'] !== 'admin') {
            $this->show404();
        }

        $this->view('admin/admin_details', ['admin' => $admin]);
    }

    /**
     * Show create admin form (GET) or process creation (POST)
     */
    public function createAdmin()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('admin/admin_create');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/admins');
            return;
        }

        $_POST = Sanitize::array($_POST);

        $userModel = $this->model('UserModel');

        if ($userModel->emailExists($_POST['email'])) {
            $this->view('admin/admin_create', ['error' => 'Email sudah terdaftar.', 'old' => $_POST]);
            return;
        }
        if ($userModel->usernameExists($_POST['username'])) {
            $this->view('admin/admin_create', ['error' => 'Username sudah digunakan.', 'old' => $_POST]);
            return;
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $userModel->create([
            'full_name' => $_POST['full_name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $hashedPassword,
            'role' => 'admin',
        ]);

        // Auto-verify admin email
        $admin = $userModel->findByEmail($_POST['email']);
        if ($admin) {
            $userModel->verifyEmail($admin['id']);
        }

        $this->adminFlash('Admin berhasil ditambahkan.');
        $this->redirect('/admin/admins');
    }

    /**
     * Legacy alias: addAdmin → createAdmin
     */
    public function addAdmin()
    {
        $this->createAdmin();
    }

    /**
     * Show edit admin form (GET) or process update (POST)
     */
    public function editAdmin($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $userModel = $this->model('UserModel');
        $admin = $userModel->findById($id);

        if (!$admin || $admin['role'] !== 'admin') {
            $this->show404();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/admins');
                return;
            }

            $_POST = Sanitize::array($_POST);

            // Email conflict check
            if ($userModel->emailExists($_POST['email'], $id)) {
                $this->view('admin/admin_edit', ['admin' => $admin, 'error' => 'Email sudah digunakan akun lain.']);
                return;
            }
            if ($userModel->usernameExists($_POST['username'], $id)) {
                $this->view('admin/admin_edit', ['admin' => $admin, 'error' => 'Username sudah digunakan akun lain.']);
                return;
            }

            $userModel->updateProfile($id, [
                'full_name' => $_POST['full_name'],
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'] ?? null,
                'address' => $_POST['address'] ?? null,
            ]);

            $this->adminFlash('Profil admin berhasil diperbarui.');
            $this->redirect('/admin/admins');
            return;
        }

        $this->view('admin/admin_edit', ['admin' => $admin]);
    }

    /**
     * Show edit admin password form (GET) or process update (POST)
     */
    public function editAdminPassword($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $userModel = $this->model('UserModel');
        $admin = $userModel->findById($id);

        if (!$admin || $admin['role'] !== 'admin') {
            $this->show404();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/admins');
                return;
            }

            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (strlen($newPassword) < 8) {
                $this->view('admin/admin_password', ['admin' => $admin, 'error' => 'Kata sandi minimal 8 karakter.']);
                return;
            }

            if ($newPassword !== $confirmPassword) {
                $this->view('admin/admin_password', ['admin' => $admin, 'error' => 'Konfirmasi kata sandi tidak cocok.']);
                return;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            $userModel->updatePassword($id, $hashedPassword);
            $userModel->setRememberToken($id, null);

            $this->adminFlash('Kata sandi admin berhasil diubah.');
            $this->redirect('/admin/admins');
            return;
        }

        $this->view('admin/admin_password', ['admin' => $admin]);
    }

    public function deleteAdmin($id = '')
    {
        $this->checkAdmin();
        if (empty($id) || $id === $_SESSION['user_id']) {
            $this->redirect('/admin/admins');
            return;
        }

        $userModel = $this->model('UserModel');
        $userModel->delete($id);

        $this->adminFlash('Admin berhasil dihapus.');
        $this->redirect('/admin/admins');
    }

    // ═══════════════════════════════════════════════════════════════
    // REVIEWS
    // ═══════════════════════════════════════════════════════════════

    public function reviews()
    {
        $this->checkAdmin();
        $reviewModel = $this->model('ReviewModel');

        $this->view('admin/reviews', [
            'reviews' => $reviewModel->getAll(),
        ]);
    }

    public function reviewDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $reviewModel = $this->model('ReviewModel');
        $review = $reviewModel->getById($id);

        if (!$review) {
            $this->show404();
        }

        $this->view('admin/review_details', ['review' => $review]);
    }

    public function updateReviewStatus($id = '')
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            $this->redirect('/admin/reviews');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/reviews');
            return;
        }

        $status = $_POST['status'] ?? '';
        if (!in_array($status, ['approved', 'rejected'])) {
            $this->redirect('/admin/reviews');
            return;
        }

        $reviewModel = $this->model('ReviewModel');
        $reviewModel->updateStatus($id, $status);

        $this->adminFlash('Status review berhasil diperbarui.');
        $this->redirect('/admin/reviews');
    }

    /**
     * Aliases for review routes used in views
     */
    public function updateTestimonialStatus($id = '')
    {
        $this->updateReviewStatus($id);
    }

    public function deleteTestimonial($id = '')
    {
        $this->checkAdmin();
        if (empty($id) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/reviews');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/reviews');
            return;
        }

        $reviewModel = $this->model('ReviewModel');
        $reviewModel->delete($id);

        $this->adminFlash('Testimoni berhasil dihapus.');
        $this->redirect('/admin/reviews');
    }

    // ═══════════════════════════════════════════════════════════════
    // CONTACTS
    // ═══════════════════════════════════════════════════════════════

    public function contacts()
    {
        $this->checkAdmin();
        $contactModel = $this->model('ContactModel');

        $this->view('admin/contacts', [
            'contacts' => $contactModel->getAll(),
        ]);
    }

    public function contactDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $contactModel = $this->model('ContactModel');
        $contact = $contactModel->getById($id);

        if (!$contact) {
            $this->show404();
        }

        // Mark as read
        if (!$contact['is_read']) {
            $contactModel->markRead($id);
        }

        $this->view('admin/contact_details', ['contact' => $contact]);
    }

    public function deleteContact($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->redirect('/admin/contacts');
            return;
        }

        $contactModel = $this->model('ContactModel');
        $contactModel->delete($id);

        $this->adminFlash('Pesan berhasil dihapus.');
        $this->redirect('/admin/contacts');
    }

    // ═══════════════════════════════════════════════════════════════
    // PAYMENT METHODS
    // ═══════════════════════════════════════════════════════════════

    public function paymentMethods()
    {
        $this->checkAdmin();
        $paymentMethodModel = $this->model('PaymentMethodModel');

        $this->view('admin/payment_methods', [
            'methods' => $paymentMethodModel->getAll(),
        ]);
    }

    /**
     * Show payment method details
     */
    public function paymentMethodDetails($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $paymentMethodModel = $this->model('PaymentMethodModel');
        $method = $paymentMethodModel->getById($id);

        if (!$method) {
            $this->show404();
        }

        $this->view('admin/payment_method_details', ['method' => $method]);
    }

    /**
     * Show create payment method form (GET) or process creation (POST)
     */
    public function createPaymentMethod()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('admin/payment_method_create');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/paymentMethods');
            return;
        }

        $_POST = Sanitize::array($_POST);

        // Handle icon upload
        $icon = null;
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
            $icon = Upload::image($_FILES['icon'], 'payment-methods');
        }

        $paymentMethodModel = $this->model('PaymentMethodModel');
        $isActive = ($_POST['is_active'] ?? '1') == '1' ? 1 : 0;

        $paymentMethodModel->create([
            'name' => $_POST['name'],
            'type' => $_POST['type'] ?? 'bank_transfer',
            'account_number' => $_POST['account_number'],
            'account_name' => $_POST['account_name'],
            'icon' => $icon,
            'instructions' => $_POST['instructions'] ?? null,
            'is_active' => $isActive,
            'sort_order' => (int)($_POST['sort_order'] ?? 0),
        ]);

        $this->adminFlash('Metode pembayaran berhasil ditambahkan.');
        $this->redirect('/admin/paymentMethods');
    }

    /**
     * Show edit payment method form (GET) or process update (POST)
     */
    public function editPaymentMethod($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->show404();
        }

        $paymentMethodModel = $this->model('PaymentMethodModel');
        $method = $paymentMethodModel->getById($id);

        if (!$method) {
            $this->show404();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/paymentMethods');
                return;
            }

            $_POST = Sanitize::array($_POST);

            $icon = $method['icon'];
            if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
                // Delete old icon if exists
                if (!empty($method['icon'])) {
                    Upload::delete($method['icon'], 'payment-methods');
                }
                $icon = Upload::image($_FILES['icon'], 'payment-methods');
            }

            $isActive = ($_POST['is_active'] ?? '1') == '1' ? 1 : 0;

            $paymentMethodModel->update($id, [
                'name' => $_POST['name'],
                'type' => $_POST['type'] ?? 'bank_transfer',
                'account_number' => $_POST['account_number'],
                'account_name' => $_POST['account_name'],
                'icon' => $icon,
                'instructions' => $_POST['instructions'] ?? null,
                'is_active' => $isActive,
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
            ]);

            $this->adminFlash('Metode pembayaran berhasil diperbarui.');
            $this->redirect('/admin/paymentMethods');
            return;
        }

        $this->view('admin/payment_method_edit', ['method' => $method]);
    }

    public function deletePaymentMethod($id = '')
    {
        $this->checkAdmin();
        if (empty($id)) {
            $this->redirect('/admin/paymentMethods');
            return;
        }

        $paymentMethodModel = $this->model('PaymentMethodModel');
        $method = $paymentMethodModel->getById($id);

        // Delete icon file if exists
        if ($method && !empty($method['icon'])) {
            Upload::delete($method['icon'], 'payment-methods');
        }

        $paymentMethodModel->delete($id);

        $this->adminFlash('Metode pembayaran berhasil dihapus.');
        $this->redirect('/admin/paymentMethods');
    }

    /**
     * Toggle payment method active status
     */
    public function togglePaymentMethod($id = '')
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($id)) {
            $this->redirect('/admin/paymentMethods');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/paymentMethods');
            return;
        }

        $paymentMethodModel = $this->model('PaymentMethodModel');
        $paymentMethodModel->toggleActive($id);

        $this->adminFlash('Status metode pembayaran berhasil diubah.');
        $this->redirect('/admin/paymentMethods');
    }
}
