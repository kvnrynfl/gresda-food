<?php 
$title = "Buat Akun";
include '../app/views/layouts/header.php'; 
?>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-[url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center relative">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-0"></div>
    
    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up">
        <div class="mb-4 flex justify-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-cyan-100/10 text-cyan-400 shadow-sm border border-cyan-500/30">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
        </div>
        <h2 class="text-center text-4xl font-extrabold text-white mb-2">Bergabung dengan Gresda Food</h2>
        <p class="mt-2 text-center text-sm text-gray-200">
            Daftar untuk melakukan pesanan pertama Anda yang lezat!
        </p>
    </div>

    <div class="relative z-10 mt-8 sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up" style="animation-delay: 0.1s;">
        <div class="bg-white py-10 px-6 shadow-[0_20px_50px_rgba(0,0,0,0.3)] sm:rounded-2xl sm:px-10 border border-gray-100/50 relative overflow-hidden">
            
            <!-- Red accent line top -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-primary"></div>

            <?php if(!empty($error)): ?>
                <div class="mb-6 bg-cyan-50 border-l-4 border-cyan-500 p-4 rounded shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-cyan-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-cyan-700 font-medium"><?= htmlspecialchars($error) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-5" action="<?= BASEURL ?>/auth/register" method="POST">
                <?= CSRF::getTokenField() ?>
                
                <div>
                    <label for="full_name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-gray-400"></i>
                        </div>
                        <input id="full_name" name="full_name" type="text" required class="pl-10 appearance-none block w-full px-3 py-3 rounded-lg border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700">Nama Pengguna</label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input id="username" name="username" type="text" required class="pl-10 appearance-none block w-full px-3 py-3 rounded-lg border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required class="pl-10 appearance-none block w-full px-3 py-3 rounded-lg border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required minlength="8" class="pl-10 appearance-none block w-full px-3 py-3 rounded-lg border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" placeholder="Minimal 8 karakter">
                    </div>
                </div>
                <div class="flex items-start mt-4">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary accent-primary">
                    </div>
                    <label for="terms" class="ml-2 text-sm font-medium text-gray-900">Saya setuju dengan <a href="<?= BASEURL ?>/legal/terms" target="_blank" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> serta <a href="<?= BASEURL ?>/legal/privacy" target="_blank" class="text-blue-600 hover:underline">Kebijakan Privasi</a>.</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm border-b-4 border-cyan-700 text-lg font-bold text-white bg-primary hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all active:border-b-0 active:translate-y-1">
                        Buat Akun
                    </button>
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
                <a href="<?= BASEURL ?>/auth/login" class="w-full flex justify-center py-3 px-4 border-2 border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                    Masuk di sini
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
</style>

<?php include '../app/views/layouts/footer.php'; ?>

