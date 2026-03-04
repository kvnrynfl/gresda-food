<?php

/**
 * Contact Controller
 */
class ContactController extends Controller
{
    public function index()
    {
        $this->view('home/contact', [
            'success' => $this->getFlash('success'),
            'error' => '',
        ]);
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contact');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->view('home/contact', ['error' => 'Sesi tidak valid.', 'success' => '']);
            return;
        }

        $_POST = Sanitize::array($_POST);

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($message)) {
            $this->view('home/contact', ['error' => 'Nama, email, dan pesan wajib diisi.', 'success' => '']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view('home/contact', ['error' => 'Format email tidak valid.', 'success' => '']);
            return;
        }

        $contactModel = $this->model('ContactModel');
        $contactModel->create([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        $this->flash('success', 'Pesan berhasil dikirim. Terima kasih atas masukan Anda!');
        $this->redirect('/contact');
    }
}
