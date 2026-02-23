<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin - Gresda Food</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-white h-screen flex items-center justify-center bg-[url('<?= BASEURL ?>/images/bg-admin.jpg')] bg-cover bg-blend-overlay bg-black/70">
    
    <div class="w-full max-w-md bg-slate-800/90 backdrop-blur-md p-10 rounded-2xl shadow-2xl border border-slate-700">
        <div class="text-center mb-8">
            <img src="<?= BASEURL ?>/images/logo/LogoGresdaBiruPutihNoBG.jpg" alt="Logo" class="h-16 w-16 mx-auto rounded-full mb-4 shadow-lg border-2 border-cyan-500">
            <h1 class="text-3xl font-bold tracking-tight text-cyan-500">Selamat datang kembali, admin</h1>
            <p class="text-slate-400 mt-2 text-sm">Masuk untuk mengelola Gresda Food & Beverage</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-cyan-500/10 border border-cyan-500 text-cyan-400 px-4 py-3 rounded mb-6 text-sm text-center">
                <i class="fas fa-exclamation-triangle mr-2"></i><?= $error ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL ?>/auth/adminLogin" method="POST" class="space-y-6">
            <?= CSRF::getTokenField() ?>
            
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Pengguna</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fas fa-user-shield"></i>
                    </span>
                    <input type="text" name="username" required class="w-full bg-slate-900 border border-slate-700 rounded-lg py-3 pl-10 pr-4 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition" placeholder="admin" value="<?= htmlspecialchars($username ?? '') ?>">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fas fa-key"></i>
                    </span>
                    <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded-lg py-3 pl-10 pr-4 text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition" placeholder="••••••">
                </div>
            </div>

            <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-cyan-600/30 transition duration-200 flex justify-center items-center gap-2">
                Masuk Aman <i class="fas fa-arrow-right text-sm"></i>
            </button>
        </form>
    </div>

</body>
</html>

