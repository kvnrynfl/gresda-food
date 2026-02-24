<?php

class ContactController extends Controller {

    public function index() {
        $data['title'] = 'Contact Us | Gresda Food & Beverage';
        $this->view('home/contact', $data);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['csrf_token']) || !CSRF::verifyToken($_POST['csrf_token'])) {
                $_SESSION['flash_error'] = "Token tidak valid atau kedaluwarsa. Silakan coba lagi.";
                $this->redirect('/contact');
                exit;
            }
            
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'message' => trim($_POST['message'] ?? '')
            ];
            
            $contactModel = $this->model('ContactModel');
            if ($contactModel->create($data)) {
                $_SESSION['flash_success'] = "Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.";
            } else {
                $_SESSION['flash_error'] = "Gagal mengirim pesanan. Silakan coba lagi nanti.";
            }
            $this->redirect('/contact');
        } else {
            $this->redirect('/contact');
        }
    }
}
