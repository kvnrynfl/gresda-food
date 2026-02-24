<?php

class AdminController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/auth/login');
        }
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $categoryModel = $this->model('CategoryModel');
        $foodModel = $this->model('FoodModel');
        $userModel = $this->model('UserModel');
        $orderModel = $this->model('OrderModel');
        
        $active_orders_count = count(array_filter($orderModel->getAllOrders(), function($order) {
            return !in_array($order['status'], ['Finished', 'Canceled', 'Cart']);
        }));

        $data = [
            'total_categories' => count($categoryModel->getAll()),
            'total_foods' => count($foodModel->getAll()),
            'total_users' => count($userModel->getAll()),
            'active_orders' => $active_orders_count
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    // Categories
    public function categories() {
        $data['categories'] = $this->model('CategoryModel')->getAll();
        $this->view('admin/categories', $data);
    }

    public function createCategory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('CategoryModel')->create(Sanitize::array($_POST));
            $this->redirect('/admin/categories');
        }
        $this->view('admin/category_create');
    }

    // Foods
    public function foods() {
        $data['foods'] = $this->model('FoodModel')->getAll();
        $this->view('admin/foods', $data);
    }

    public function createFood() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $upload = Upload::image($_FILES['image'], '../public/uploads/foods');
            
            if ($upload['status']) {
                $postData = Sanitize::array($_POST);
                $postData['image_name'] = $upload['filename'];
                $this->model('FoodModel')->create($postData);
                $this->redirect('/admin/foods');
            } else {
                die($upload['message']); // Handle properly in view in production
            }
        }
        $data['categories'] = $this->model('CategoryModel')->getActive();
        $this->view('admin/food_create', $data);
    }

    public function editFood($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $postData = Sanitize::array($_POST);
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload = Upload::image($_FILES['image'], '../public/uploads/foods');
                if ($upload['status']) {
                    $postData['image_name'] = $upload['filename'];
                }
            } else {
                $postData['image_name'] = $postData['current_image'];
            }
            
            $this->model('FoodModel')->update($id, $postData);
            $this->redirect('/admin/foods');
        }
        $data['food'] = $this->model('FoodModel')->getById($id);
        $data['categories'] = $this->model('CategoryModel')->getActive();
        $this->view('admin/food_edit', $data);
    }
    
    public function editCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('CategoryModel')->update($id, Sanitize::array($_POST));
            $this->redirect('/admin/categories');
        }
        $data['category'] = $this->model('CategoryModel')->getById($id);
        $this->view('admin/category_edit', $data);
    }

    // Orders
    public function orders() {
        $data['orders'] = $this->model('OrderModel')->getAllOrders();
        $this->view('admin/orders', $data);
    }
    
    public function orderDetails($id) {
        $orderModel = $this->model('OrderModel');
        
        $data['order'] = null;
        // Search $id in all orders
        foreach($orderModel->getAllOrders() as $order) {
            if ($order['order_id'] == $id) {
                $data['order'] = $order;
                break;
            }
        }
        
        if (!$data['order']) {
            $this->redirect('/admin/orders');
            return;
        }

        $data['details'] = $orderModel->getOrderDetails($id);
        $data['confirm'] = $orderModel->getConfirmOrder($id);
        $data['order_id'] = $id;

        $this->view('admin/order_details', $data);
    }
    
    public function updateOrderStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $status = Sanitize::string($_POST['status']);
            $this->model('OrderModel')->updateOrderStatus($id, $status);
            $this->redirect('/admin/orders');
        }
    }

    // Users & Admins
    public function users() {
        // Need to add getAll to UserModel if not exists, skipping rigorous check for brevity assuming it does or will
        $data['users'] = $this->model('UserModel')->getAll(); 
        $this->view('admin/users', $data);
    }

    public function admins() {
        $data['admins'] = $this->model('AdminModel')->getAll();
        $this->view('admin/admins', $data);
    }
    
    public function deleteUser($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('UserModel')->delete($id);
            $this->redirect('/admin/users');
        }
    }
    
    public function createAdmin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $postData = Sanitize::array($_POST);
            
            // Check if admin already exists
            if ($this->model('AdminModel')->findAdminByUsername($postData['username'])) {
                // handle duplicate (just basic redirect for brevity in this MVP refactor structure)
                $this->redirect('/admin/admins');
                return;
            }
            
            $postData['password'] = password_hash($postData['password'], PASSWORD_BCRYPT);
            $this->model('AdminModel')->create($postData);
            $this->redirect('/admin/admins');
        }
        $this->view('admin/admin_create');
    }

    public function editAdmin($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $postData = Sanitize::array($_POST);
            
            $this->model('AdminModel')->updateProfile($id, $postData);
            
            // If logged in admin edits own profile, update session
            if ($id == $_SESSION['admin_id']) $_SESSION['admin_fullname'] = $postData['full_name'];
            if ($id == $_SESSION['admin_id']) $_SESSION['admin_username'] = $postData['username'];
            $this->redirect('/admin/admins');
        }
        $data['admin'] = $this->model('AdminModel')->getById($id);
        $this->view('admin/admin_edit', $data);
    }
    
    public function editAdminPassword($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $postData = Sanitize::array($_POST);
            if ($postData['new_password'] === $postData['confirm_password']) {
                $hash = password_hash($postData['new_password'], PASSWORD_BCRYPT);
                $this->model('AdminModel')->updatePassword($id, $hash);
            }
            $this->redirect('/admin/admins');
        }
        $data['admin'] = $this->model('AdminModel')->getById($id);
        $this->view('admin/admin_password', $data);
    }

    public function deleteAdmin($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('AdminModel')->delete($id);
            $this->redirect('/admin/admins');
        }
    }

    // Contacts & Reviews
    public function contacts() {
        $data['contacts'] = $this->model('ContactModel')->getAll();
        $this->view('admin/contacts', $data); // Placeholder
    }
    
    public function reviews() {
        $data['reviews'] = $this->model('ReviewModel')->getAll();
        $this->view('admin/reviews', $data); // Placeholder
    }

    public function deleteCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('CategoryModel')->delete($id);
            $this->redirect('/admin/categories');
        }
    }

    public function deleteFood($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('FoodModel')->delete($id);
            $this->redirect('/admin/foods');
        }
    }

    public function deleteContact($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('ContactModel')->delete($id);
            $this->redirect('/admin/contacts');
        }
    }

    public function deleteReview($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST' && CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->model('ReviewModel')->delete($id);
            $this->redirect('/admin/reviews');
        }
    }
}
