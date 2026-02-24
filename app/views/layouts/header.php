<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gresda Food & Beverage' ?></title>
    
    <!-- Modern Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome & Boxicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- SweetAlert2 Global -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Tailwind CSS (CDN for rapid delivery as requested) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#06b6d4',
                        secondary: '#2D3748'
                    }
                }
            }
        }
    </script>
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <?php if(isset($_SESSION['flash_error']) || isset($_SESSION['flash_success'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(isset($_SESSION['flash_error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= addslashes($_SESSION['flash_error']) ?>',
                confirmButtonColor: '#06b6d4'
            });
            <?php unset($_SESSION['flash_error']); endif; ?>
            
            <?php if(isset($_SESSION['flash_success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= addslashes($_SESSION['flash_success']) ?>',
                confirmButtonColor: '#06b6d4'
            });
            <?php unset($_SESSION['flash_success']); endif; ?>
        });
    </script>
    <?php endif; ?>

    <!-- Navigation Bar -->
    <nav id="navbar" class="transition-all duration-300 fixed w-full z-50 <?php echo (isset($title) && $title === 'Home') ? 'bg-transparent py-4 text-white' : 'bg-white shadow-md text-gray-800 py-0 border-b border-gray-100'; ?>">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 transition-all duration-300" id="nav-container">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?= BASEURL ?>" class="block">
                        <div class="text-2xl font-black italic tracking-tighter">
                            <span class="text-primary">GRESDA</span> 
                            <span id="nav-logo-text" class="<?php echo (isset($title) && $title === 'Home') ? 'text-white' : 'text-secondary'; ?>">FOOD</span>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?= BASEURL ?>/" class="nav-link font-medium hover:text-primary transition <?php echo (isset($title) && $title === 'Home') ? 'text-white' : 'text-gray-600'; ?>">Beranda</a>
                    <a href="<?= BASEURL ?>/about" class="nav-link font-medium hover:text-primary transition <?php echo (isset($title) && $title === 'Home') ? 'text-white' : 'text-gray-600'; ?>">Tentang Kami</a>
                    <a href="<?= BASEURL ?>/menu" class="nav-link font-medium hover:text-primary transition <?php echo (isset($title) && $title === 'Home') ? 'text-white' : 'text-gray-600'; ?>">Menu</a>
                    <a href="<?= BASEURL ?>/contact" class="nav-link font-medium hover:text-primary transition <?php echo (isset($title) && $title === 'Home') ? 'text-white' : 'text-gray-600'; ?>">Kontak</a>
                    
                    <?php if(isset($_SESSION['role'])): 
                        $globalCartCount = 0;
                        if($_SESSION['role'] === 'customer') {
                            require_once '../app/models/OrderModel.php';
                            if(class_exists('OrderModel')) {
                                $om = new OrderModel();
                                $ac = $om->getActiveCartByUser($_SESSION['user_id']);
                                if($ac) {
                                    $globalItems = $om->getOrderDetails($ac['order_id']);
                                    $globalCartCount = count($globalItems);
                                }
                            }
                        }
                    ?>
                        <?php if($_SESSION['role'] === 'customer'): ?>
                        <a href="<?= BASEURL ?>/customer/cart" class="relative nav-link transition hover:text-primary <?php echo (isset($title) && $title === 'Home') ? 'text-white' : 'text-gray-600'; ?>">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <?php if($globalCartCount > 0): ?>
                                <span class="absolute -top-2 -right-3 bg-primary text-white text-xs px-2 py-0.5 rounded-full"><?= $globalCartCount ?></span>
                            <?php endif; ?>
                        </a>
                        <?php endif; ?>
                        
                        <div class="relative group <?php echo ($_SESSION['role'] === 'customer') ? 'ml-4' : ''; ?>">
                            <button class="flex items-center gap-2 nav-link font-medium hover:text-primary transition <?php echo (isset($title) && $title === 'Home') ? 'text-white' : 'text-gray-600'; ?>">
                                <i class="fas fa-user-circle text-xl"></i>
                                <?= $_SESSION['username'] ?? $_SESSION['admin_username'] ?>
                            </button>
                            <div class="absolute right-0 w-64 mt-2 bg-white border border-gray-100 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100 z-50">
                                <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 rounded-t-xl">
                                    <p class="text-sm font-bold text-gray-900 truncate"><?= htmlspecialchars($_SESSION['username'] ?? $_SESSION['admin_username']) ?></p>
                                    <p class="text-xs text-gray-500 truncate flex items-center gap-1 mt-1"><i class="fas fa-check-circle text-green-500"></i> <?= $_SESSION['role'] === 'admin' ? 'Akun Administrator' : 'Akun Pelanggan' ?></p>
                                </div>
                                <div class="py-2">
                                    <?php if($_SESSION['role'] === 'admin'): ?>
                                    <a href="<?= BASEURL ?>/admin/dashboard" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-cyan-50 hover:text-primary transition flex items-center gap-3"><i class="fas fa-tachometer-alt text-gray-400 w-4 text-center"></i> Dashboard Admin</a>
                                    <?php else: ?>
                                    <a href="<?= BASEURL ?>/customer/profile" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-cyan-50 hover:text-primary transition flex items-center gap-3"><i class="fas fa-user-circle text-gray-400 w-4 text-center"></i> Profil Saya</a>
                                    <a href="<?= BASEURL ?>/customer/editProfile" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-cyan-50 hover:text-primary transition flex items-center gap-3"><i class="fas fa-cog text-gray-400 w-4 text-center"></i> Pengaturan Akun</a>
                                    <a href="<?= BASEURL ?>/customer/orders" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-cyan-50 hover:text-primary transition flex items-center gap-3"><i class="fas fa-history text-gray-400 w-4 text-center"></i> Riwayat Transaksi</a>
                                    <?php endif; ?>
                                </div>
                                <div class="border-t border-gray-100"></div>
                                <div class="py-1">
                                    <a href="<?= BASEURL ?>/auth/logout" class="block px-5 py-3 text-sm font-bold text-red-500 hover:bg-red-50 transition flex items-center gap-3 rounded-b-xl"><i class="fas fa-sign-out-alt text-red-400 w-4 text-center"></i> Keluar</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASEURL ?>/auth/login" class="px-6 py-2.5 bg-primary text-white rounded-full font-medium hover:bg-cyan-600 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Masuk</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-500 hover:text-primary focus:outline-none transition <?php echo (isset($title) && $title === 'Home') ? 'text-white' : ''; ?>">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 top-16 z-40 transition-all origin-top">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="<?= BASEURL ?>/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">Beranda</a>
                <a href="<?= BASEURL ?>/about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">Tentang Kami</a>
                <a href="<?= BASEURL ?>/menu" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">Menu</a>
                <a href="<?= BASEURL ?>/contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">Kontak</a>
                
                <?php if(isset($_SESSION['role'])): ?>
                    <?php if($_SESSION['role'] === 'customer'): ?>
                    <a href="<?= BASEURL ?>/customer/cart" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">
                        <i class="fas fa-shopping-cart w-5 mr-1 text-center"></i> Keranjang (<span class="text-primary"><?= $globalCartCount ?? 0 ?></span>)
                    </a>
                    <a href="<?= BASEURL ?>/customer/profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">
                        <i class="fas fa-user-circle w-5 mr-1 text-center"></i> Profil Saya
                    </a>
                    <a href="<?= BASEURL ?>/customer/orders" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">
                        <i class="fas fa-history w-5 mr-1 text-center"></i> Riwayat
                    </a>
                    <?php else: ?>
                    <a href="<?= BASEURL ?>/admin/dashboard" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-cyan-50 border-b border-gray-50">
                        <i class="fas fa-tachometer-alt w-5 mr-1 text-center"></i> Dashboard Admin
                    </a>
                    <?php endif; ?>
                    <a href="<?= BASEURL ?>/auth/logout" class="block px-3 py-2 rounded-md font-bold text-red-500 hover:bg-red-50 mt-2 border-t border-gray-50">
                        <i class="fas fa-sign-out-alt w-5 mr-1 text-center"></i> Keluar
                    </a>
                <?php else: ?>
                    <a href="<?= BASEURL ?>/auth/login" class="block px-3 py-2 rounded-md text-base font-bold text-primary hover:bg-cyan-50 mt-2 text-center bg-cyan-50">
                        Masuk / Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Navbar Scroll Script specific constraints for Homepage -->
    <?php if (isset($title) && $title === 'Home'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            const navLinks = document.querySelectorAll('.nav-link');
            const logoText = document.getElementById('nav-logo-text');
            const navContainer = document.getElementById('nav-container');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.remove('bg-transparent', 'text-white', 'py-4');
                    navbar.classList.add('bg-white', 'shadow-md', 'text-gray-800', 'py-0', 'border-b', 'border-gray-100');
                    logoText.classList.remove('text-white');
                    logoText.classList.add('text-secondary');
                    
                    navLinks.forEach(link => {
                        link.classList.remove('text-white');
                        link.classList.add('text-gray-600');
                    });
                } else {
                    navbar.classList.add('bg-transparent', 'text-white', 'py-4');
                    navbar.classList.remove('bg-white', 'shadow-md', 'text-gray-800', 'py-0', 'border-b', 'border-gray-100');
                    logoText.classList.add('text-white');
                    logoText.classList.remove('text-secondary');
                    
                    navLinks.forEach(link => {
                        link.classList.add('text-white');
                        link.classList.remove('text-gray-600');
                    });
                    if (document.getElementById('mobile-menu-btn')) {
                        document.getElementById('mobile-menu-btn').classList.add('text-white');
                        document.getElementById('mobile-menu-btn').classList.remove('text-gray-600');
                    }
                }
            });
        });
    </script>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle Logics
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

    <!-- Main Content Wrapper -->
    <main class="flex-grow <?php echo (!isset($title) || $title !== 'Home') ? 'pt-16' : ''; ?>">

