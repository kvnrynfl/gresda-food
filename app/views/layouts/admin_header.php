<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Portal' ?> - Gresda Food</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col h-full hidden md:flex">
        <div class="h-16 flex items-center justify-center bg-slate-950 border-b border-slate-800">
            <span class="text-xl font-bold text-white tracking-wider text-cyan-500"><i class="fas fa-utensils mr-2 text-white"></i> GresdaAdmin</span>
        </div>
        <div class="flex-1 overflow-y-auto py-4">
            <nav class="space-y-1 px-2">
                <a href="<?= BASEURL ?>/admin/dashboard" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-tachometer-alt mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Dasbor
                </a>
                <a href="<?= BASEURL ?>/admin/orders" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'orders') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-shopping-bag mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'orders') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Pesanan
                    <span class="ml-auto bg-cyan-500 text-white py-0.5 px-2 rounded-full text-xs">Baru</span>
                </a>
                <a href="<?= BASEURL ?>/admin/categories" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'categories') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-tags mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'categories') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Kategori
                </a>
                <a href="<?= BASEURL ?>/admin/foods" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'foods') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-hamburger mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'foods') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Menu Makanan
                </a>
                
                <div class="px-4 mt-6 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Manajemen Pengguna</p>
                </div>
                <a href="<?= BASEURL ?>/admin/users" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'users') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-users mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'users') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Pelanggan
                </a>
                <a href="<?= BASEURL ?>/admin/admins" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'admins') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-user-shield mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'admins') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Administrator
                </a>

                <div class="px-4 mt-6 mb-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kontak & Ulasan</p>
                </div>
                <a href="<?= BASEURL ?>/admin/reviews" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'reviews') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-star mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'reviews') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Ulasan Pelanggan
                </a>
                <a href="<?= BASEURL ?>/admin/contacts" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md <?= (strpos($_SERVER['REQUEST_URI'], 'contacts') !== false) ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white transition' ?>">
                    <i class="fas fa-envelope mr-3 text-lg <?= (strpos($_SERVER['REQUEST_URI'], 'contacts') !== false) ? 'text-cyan-500' : 'text-slate-400 group-hover:text-cyan-500' ?>"></i> Pesan Masuk
                </a>
            </nav>
        </div>
        <div class="p-4 bg-slate-950">
            <a href="<?= BASEURL ?>/auth/logout" class="flex items-center text-sm font-medium text-slate-400 hover:text-white transition group">
                <i class="fas fa-sign-out-alt mr-3 group-hover:text-cyan-500"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Top bar -->
        <header class="bg-white shadow h-16 flex items-center justify-between px-8 z-10">
            <h1 class="text-2xl font-bold text-gray-800"><?= $title ?? 'Dasbor' ?></h1>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-500">Selamat datang kembali, <span class="text-gray-900 font-bold"><?= $_SESSION['admin_fullname'] ?? $_SESSION['admin_username'] ?? 'Admin' ?></span></span>
                <img src="<?= BASEURL ?>/images/default.jpg" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['admin_username'] ?? 'A') ?>&background=E53E3E&color=fff'" class="h-8 w-8 rounded-full border border-gray-300 shadow-sm">
            </div>
        </header>

        <!-- Main section start -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">

