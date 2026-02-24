<?php 
$auth_heading = "Selamat Datang Kembali";
$auth_subheading = "Masuk untuk mengelola keranjang, pesanan, dan profil Anda.";
ob_start(); 
?>

<form class="space-y-6" action="<?= BASEURL ?>/auth/login" method="POST">
    <?= CSRF::getTokenField() ?>
    
    <?php 
    $props = ['name' => 'login_id', 'label' => 'Nama Pengguna atau Email', 'icon' => 'fas fa-user', 'placeholder' => 'username atau email', 'required' => true, 'value' => $login_id ?? ''];
    include '../app/views/components/ui/input.php';
    ?>

    <?php
    $props = ['name' => 'password', 'type' => 'password', 'label' => 'Kata Sandi', 'icon' => 'fas fa-lock', 'placeholder' => '••••••••', 'required' => true];
    include '../app/views/components/ui/input.php';
    ?>

    <div class="flex items-center justify-between">
        <div class="flex items-center hidden">
            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                Ingat saya
            </label>
        </div>

        <div class="text-sm">
            <a href="#" class="font-medium text-primary hover:text-cyan-700 transition">
                Lupa kata sandi Anda?
            </a>
        </div>
    </div>

    <div>
        <?php 
        $props = ['text' => 'Masuk', 'type' => 'submit', 'variant' => 'primary', 'w_full' => true, 'class' => 'border-b-4 border-cyan-700 text-lg'];
        include '../app/views/components/ui/button.php';
        ?>
    </div>
</form>

<div class="mt-8 relative">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-200"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="px-2 bg-white text-gray-500 font-medium tracking-wide">
            Belum punya akun?
        </span>
    </div>
</div>

<div class="mt-6">
    <?php 
    $props = ['text' => 'Buat Akun Baru', 'type' => 'a', 'href' => BASEURL . '/auth/register', 'variant' => 'outline', 'w_full' => true];
    include '../app/views/components/ui/button.php';
    ?>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/auth_layout.php'; 
?>

