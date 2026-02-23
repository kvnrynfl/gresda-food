<?php include '../app/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-[url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center relative">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-0"></div>
    
    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up">
        <h2 class="text-center text-4xl font-extrabold text-white mb-2">Selamat Datang Kembali</h2>
        <p class="mt-2 text-center text-sm text-gray-200">
            Masuk untuk mengelola keranjang, pesanan, dan profil Anda.
        </p>
    </div>

    <div class="relative z-10 mt-8 sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up" style="animation-delay: 0.1s;">
        <div class="bg-white py-10 px-6 shadow-[0_20px_50px_rgba(0,0,0,0.3)] sm:rounded-2xl sm:px-10 border border-gray-100/50 relative overflow-hidden">
            
            <!-- Red accent line top -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-primary"></div>

            <?php if (!empty($error)): ?>
                <div class="bg-cyan-50 border-l-4 border-cyan-500 p-4 mb-6 rounded shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-cyan-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-cyan-700 font-medium"><?= $error ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form class="space-y-6" action="<?= BASEURL ?>/auth/login" method="POST">
                <?= CSRF::getTokenField() ?>
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required class="pl-10 appearance-none block w-full px-3 py-3 rounded-lg border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" placeholder="anda@contoh.com" value="<?= htmlspecialchars($email ?? '') ?>">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="pl-10 appearance-none block w-full px-3 py-3 rounded-lg border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" placeholder="••••••••">
                    </div>
                </div>

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
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm border-b-4 border-cyan-700 text-lg font-bold text-white bg-primary hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all active:border-b-0 active:translate-y-1">
                        Masuk
                    </button>
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
                <a href="<?= BASEURL ?>/auth/register" class="w-full flex justify-center py-3 px-4 border-2 border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                    Buat Akun Baru
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

