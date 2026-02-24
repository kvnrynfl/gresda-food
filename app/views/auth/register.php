<?php 
$auth_heading = "Bergabung dengan Gresda Food";
$auth_subheading = "Daftar untuk melakukan pesanan pertama Anda yang lezat!";
ob_start(); 
?>

<!-- Decorative Icon for Register Only -->
<div class="mb-4 flex justify-center -mt-6">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-cyan-100/10 text-cyan-400 shadow-sm border border-cyan-500/30">
        <i class="fas fa-user-plus text-2xl"></i>
    </div>
</div>

<form class="space-y-5" action="<?= BASEURL ?>/auth/register" method="POST">
    <?= CSRF::getTokenField() ?>
    
    <?php 
    $props = ['name' => 'full_name', 'label' => 'Nama Lengkap', 'icon' => 'fas fa-id-card', 'required' => true];
    include '../app/views/components/ui/input.php';

    $props = ['name' => 'username', 'label' => 'Nama Pengguna', 'icon' => 'fas fa-user', 'required' => true];
    include '../app/views/components/ui/input.php';

    $props = ['name' => 'email', 'type' => 'email', 'label' => 'Alamat Email', 'icon' => 'fas fa-envelope', 'required' => true];
    include '../app/views/components/ui/input.php';

    $props = ['name' => 'password', 'type' => 'password', 'label' => 'Kata Sandi', 'icon' => 'fas fa-lock', 'placeholder' => 'Minimal 8 karakter', 'required' => true];
    include '../app/views/components/ui/input.php';
    ?>

    <div class="flex items-start mt-4">
        <div class="flex items-center h-5">
            <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary accent-primary">
        </div>
        <label for="terms" class="ml-2 text-sm font-medium text-gray-900">Saya setuju dengan <a href="<?= BASEURL ?>/legal/terms" target="_blank" class="text-primary hover:text-cyan-700 hover:underline">Syarat & Ketentuan</a> serta <a href="<?= BASEURL ?>/legal/privacy" target="_blank" class="text-primary hover:text-cyan-700 hover:underline">Kebijakan Privasi</a>.</label>
    </div>

    <div class="pt-2">
        <?php 
        $props = ['text' => 'Buat Akun', 'type' => 'submit', 'variant' => 'primary', 'w_full' => true, 'class' => 'border-b-4 border-cyan-700 text-lg'];
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
            Sudah punya akun?
        </span>
    </div>
</div>

<div class="mt-6">
    <?php 
    $props = ['text' => 'Masuk di sini', 'type' => 'a', 'href' => BASEURL . '/auth/login', 'variant' => 'outline', 'w_full' => true];
    include '../app/views/components/ui/button.php';
    ?>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/auth_layout.php'; 
?>

