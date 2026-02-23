<?php 
$title = "Edit Profil";
include '../app/views/layouts/header.php'; 
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="<?= BASEURL ?>/customer/profile" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h2>
                </div>
            </div>
            
            <div class="p-8">
                <?php if(isset($error)): ?>
                    <div class="bg-cyan-50 text-cyan-600 p-4 rounded-lg mb-6 flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-xl"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($success)): ?>
                    <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 flex items-center gap-3">
                        <i class="fas fa-check-circle text-xl"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= BASEURL ?>/customer/updateProfile" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?= CSRF::getTokenField() ?>
                    
                    <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="relative group">
                            <img src="<?= BASEURL ?>/images/users/<?= htmlspecialchars($user['img_user'] ?? 'default.jpg') ?>" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                            <label class="absolute inset-0 bg-black/50 text-white rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition">
                                <i class="fas fa-camera text-xl mb-1"></i>
                                <span class="text-xs font-bold">Ubah</span>
                                <input type="file" name="image" accept="image/*" class="hidden">
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
                            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pengguna</label>
                            <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full px-4 py-3 bg-gray-100 border border-gray-200 text-gray-500 rounded-xl focus:outline-none" readonly title="Email tidak dapat diubah langsung karena alasan keamanan">
                        <p class="text-xs text-gray-400 mt-2"><i class="fas fa-info-circle"></i> Hubungi dukungan untuk mengubah email utama Anda.</p>
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
                        <button type="submit" class="px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-xl shadow-lg shadow-cyan-500/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>

