<?php

class AuthController extends Controller {

    public function login() {
        // If GET, load User Login View
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = ['email' => '', 'error' => ''];
            $this->view('auth/login', $data);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate CSRF
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                die('Validasi token CSRF gagal. Permintaan tidak sah.');
            }

            // Sanitize inputs
            $_POST = Sanitize::array($_POST);

            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = $this->model('UserModel');
            $user = $userModel->findUserByEmail($email);

            if ($user) {
                // Verify against Bcrypt or legacy SHA1
                if (password_verify($password, $user['password'])) {
                    $this->createUserSession($user);
                } elseif (sha1($password) === $user['password']) {
                    // Upgrade legacy hash to Bcrypt
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $userModel->updatePassword($user['id'], $newHash);
                    $this->createUserSession($user);
                } else {
                    $this->view('auth/login', ['error' => 'Kata sandi salah', 'email' => $email]);
                }
            } else {
                $this->view('auth/login', ['error' => 'Tidak ada pengguna yang ditemukan dengan email tersebut', 'email' => $email]);
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = ['error' => ''];
            $this->view('auth/register', $data);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                die('Validasi CSRF gagal.');
            }
            
            $_POST = Sanitize::array($_POST);
            
            // Check if email already exists
            $userModel = $this->model('UserModel');
            if ($userModel->findUserByEmail($_POST['email'])) {
                $this->view('auth/register', ['error' => 'Email sudah terdaftar.']);
                return;
            }
            
            // Hash password and save
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            if ($userModel->create($_POST)) {
                $this->redirect('/auth/login');
            } else {
                $this->view('auth/register', ['error' => 'Pendaftaran gagal. Silakan coba lagi.']);
            }
        }
    }

    public function adminLogin() {
        // If GET, load Admin Login View
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = ['username' => '', 'error' => ''];
            $this->view('auth/admin-login', $data);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate CSRF
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                die('Validasi token CSRF gagal. Permintaan tidak sah.');
            }

            // Sanitize inputs
            $_POST = Sanitize::array($_POST);

            $username = $_POST['username'];
            $password = $_POST['password'];

            $adminModel = $this->model('AdminModel');
            $admin = $adminModel->findAdminByUsername($username);

            if ($admin) {
                // Verification against Bcrypt or legacy MD5
                if (password_verify($password, $admin['password'])) {
                    $this->createAdminSession($admin);
                } elseif (md5($password) === $admin['password']) {
                    // Upgrade legacy hash to Bcrypt
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $adminModel->updatePassword($admin['id'], $newHash);
                    $this->createAdminSession($admin);
                } else {
                    $this->view('auth/admin-login', ['error' => 'Kata sandi salah', 'username' => $username]);
                }
            } else {
                $this->view('auth/admin-login', ['error' => 'Tidak ada admin yang ditemukan dengan nama pengguna tersebut', 'username' => $username]);
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/');
    }

    private function createUserSession($user) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = 'customer';

        $this->redirect('/'); // Redirect to Home or User Dashboard
    }

    private function createAdminSession($admin) {
        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_fullname'] = $admin['full_name'] ?? $admin['username'];
        $_SESSION['role'] = 'admin';

        $this->redirect('/admin/dashboard'); // Redirect to Admin Dashboard
    }
}
