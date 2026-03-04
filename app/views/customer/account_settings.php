<?php 
$page_title = "Pengaturan Akun";
$back_link = BASEURL . "/customer/profile";
$hide_card = true;
ob_start(); 
?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">    
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

        <form action="<?= BASEURL ?>/customer/updateProfile" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= CSRF::getTokenField() ?>
            
            <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-xl border border-gray-200 !mt-1">
                <div class="relative group">
                    <img id="profileImagePreview" src="<?= BASEURL ?>/images/users/<?= htmlspecialchars($user['img_user'] ?? 'default.jpg') ?>" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user['username'] ?? 'User') ?>&background=E53E3E&color=fff'">
                    <label class="absolute inset-0 bg-black/50 text-white rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition">
                        <i class="fas fa-camera text-xl mb-1"></i>
                        <span class="text-xs font-bold">Ubah</span>
                        <input type="file" name="image" id="profileImageInput" accept="image/*" class="hidden">
                    </label>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Foto Profil</h3>
                    <p class="text-sm text-gray-500">JPG, GIF atau PNG. Ukuran maksimal 2MB.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pengguna (Username)</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
            </div>

            <hr class="my-6 border-gray-100">
            
            <div>
                <h4 class="font-bold text-gray-800 mb-4">Keamanan</h4>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex justify-between items-center">
                    <div>
                        <div class="font-bold text-yellow-800">Kata Sandi Akun</div>
                        <div class="text-sm text-yellow-700">Ubah kata sandi Anda untuk menjaga keamanan akun Anda.</div>
                    </div>
                    <a href="<?= BASEURL ?>/customer/changePassword" class="px-4 py-2 bg-yellow-100 text-yellow-800 font-bold rounded-lg hover:bg-yellow-200 transition text-sm">
                        Ubah Kata Sandi
                    </a>
                </div>
            </div>
            
            <div class="pt-4 flex justify-end gap-3">
                <a href="<?= BASEURL ?>/customer/profile" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition">Batal</a>
                <button type="submit" class="px-6 py-3 bg-primary hover:bg-cyan-800 text-white font-bold rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('profileImageInput').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileImagePreview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>

