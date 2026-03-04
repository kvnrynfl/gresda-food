<?php 
$page_title = "Ubah Kata Sandi";
$back_link = BASEURL . "/customer/editProfile";
$hide_card = true;
ob_start(); 
?>

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                <a href="<?= BASEURL ?>/customer/editProfile" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Keamanan</h2>
            </div> -->
            
            <div class="p-8">
                <?php if(!empty($error)): ?>
                    <div class="bg-cyan-50 text-primary p-4 rounded-lg mb-6 flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-xl"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty($success)): ?>
                    <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 flex items-center gap-3">
                        <i class="fas fa-check-circle text-xl"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-8 text-center text-gray-500">
                    <i class="fas fa-shield-alt text-5xl mb-4 text-gray-300"></i>
                    <p>Buat kata sandi yang kuat untuk melindungi akun Anda.</p>
                </div>

                <form action="<?= BASEURL ?>/customer/updatePassword" method="POST" class="space-y-6">
                    <?= CSRF::getTokenField() ?>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                        <input type="password" name="old_password" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" name="new_password" required minlength="8" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                        <p class="text-xs text-gray-500 mt-2">Harus minimal 8 karakter panjangnya.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="confirm_password" required minlength="8" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                    </div>
                    
                    <button type="submit" class="w-full bg-primary hover:bg-cyan-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                        Perbarui Kata Sandi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>

