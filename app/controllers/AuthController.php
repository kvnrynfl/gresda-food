<?php

class AuthController extends Controller {

    public function admin() {
        $this->adminLogin();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = ['login_id' => '', 'error' => ''];
            $this->view('auth/login', $data);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                die('Validasi token CSRF gagal. Permintaan tidak sah.');
            }

            $_POST = Sanitize::array($_POST);

            $loginId = $_POST['login_id'] ?? $_POST['email']; // Support 'email' name temporarily if view isn't fully updated yet
            $password = $_POST['password'];

            $userModel = $this->model('UserModel');
            $user = $userModel->findByUsernameOrEmail($loginId);

            if ($user) {
                // Verify against Bcrypt or legacy SHA1/MD5
                $valid = false;
                if (password_verify($password, $user['password'])) {
                    $valid = true;
                } elseif (sha1($password) === $user['password'] || md5($password) === $user['password']) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $userModel->updatePassword($user['id'], $newHash);
                    $valid = true;
                }

                if ($valid) {
                    if ($user['role'] === 'admin') {
                        $this->createAdminSession($user);
                    } else {
                        $this->createUserSession($user);
                    }
                } else {
                    $this->view('auth/login', ['error' => 'Kata sandi salah', 'login_id' => $loginId]);
                }
            } else {
                $this->view('auth/login', ['error' => 'Akun tidak ditemukan', 'login_id' => $loginId]);
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
        // Deprecated, redirect to normal login
        $this->redirect('/auth/login');
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
