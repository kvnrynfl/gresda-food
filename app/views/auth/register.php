<?php 
$title = "Buat Akun";
include '../app/views/layouts/header.php'; 
?>

<div class="bg-gray-50 flex py-16">
    <div class="container mx-auto px-4 max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 text-center bg-gray-50 border-b border-gray-100">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-cyan-100 text-cyan-600 mb-4 shadow-sm border border-cyan-200">
                    <i class="fas fa-user-plus text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Bergabung dengan Gresda Food</h2>
                <p class="text-sm text-gray-500 mt-2">Daftar untuk melakukan pesanan pertama Anda yang lezat!</p>
            </div>
            
            <div class="p-8">
                <?php if(!empty($error)): ?>
                    <div class="mb-6 p-4 bg-cyan-50 border-l-4 border-cyan-500 text-cyan-700 text-sm font-medium rounded-r shadow-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form class="space-y-5" action="<?= BASEURL ?>/auth/register" method="POST">
                    <?= CSRF::getTokenField() ?>
                    
                    <div>
                        <label for="full_name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input id="full_name" name="full_name" type="text" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-bold text-gray-700 mb-2">Nama Pengguna</label>
                        <input id="username" name="username" type="text" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                        <input id="password" name="password" type="password" required minlength="8" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                        <p class="text-xs text-gray-500 mt-2">Minimal 8 karakter</p>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-cyan-500/30 text-sm font-bold text-white bg-primary hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition transform hover:-translate-y-0.5 active:translate-y-0">
                            Buat Akun
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm">
                    <span class="text-gray-500">Sudah punya akun?</span>
                    <a href="<?= BASEURL ?>/auth/login" class="font-bold text-primary hover:text-cyan-700 ml-1 hover:underline">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>

