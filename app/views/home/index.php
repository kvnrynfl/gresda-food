<?php include '../app/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="relative bg-secondary text-white min-h-screen flex items-center justify-center pt-16">
    <!-- Dynamic Background Image Container -->
    <div id="hero-bg-container" class="absolute inset-0 z-0 overflow-hidden">
        <!-- JS will inject layers here -->
    </div>

    <div class="absolute inset-0 z-10 bg-black/60 flex"></div>
    
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center w-full">
        <div class="flex flex-col items-center max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)] animate-fade-in-up">
                Pengalaman <span class="text-primary italic">Rasa Premium</span> 
                <br>Keunggulan Kuliner
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-10 drop-shadow-md">
                Gresda Food & Beverage menawarkan hidangan steak kelas dunia, sajian barat yang lezat, dan suasana yang menenangkan.
            </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="#menu" class="px-8 py-4 bg-primary text-white rounded-full font-bold text-lg hover:bg-cyan-700 hover:scale-105 transition transform shadow-lg flex items-center gap-2">
                <i class="fas fa-utensils"></i> Lihat Menu
            </a>
            <a href="<?= BASEURL ?>/about" class="px-8 py-4 bg-white/90 text-secondary rounded-full font-bold text-lg hover:bg-white hover:scale-105 transition transform shadow-lg flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Temukan Info Lebih Lanjut
            </a>
        </div>
        </div>
    </div>
</section>

<!-- Features / About Section Summary -->
<section id="about" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">Tentang Kami</h2>
        <h3 class="text-4xl md:text-5xl font-extrabold text-secondary mb-6">Mengapa Memilih Gresda Food?</h3>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-10">Kami hanya mengambil bahan-bahan segar dan daging sapi impor terbaik untuk memastikan setiap gigitan adalah pengalaman yang luar biasa. Dibuat dengan penuh renjana oleh koki ahli.</p>
        <a href="<?= BASEURL ?>/about" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-full font-bold text-lg hover:bg-cyan-700 transition transform shadow hover:scale-105">
            Baca Kisah Lengkap Kami <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- Menu Preview Section -->
<section id="menu" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">Signature Kami</h2>
                <h3 class="text-4xl font-extrabold text-secondary">Temukan Menu</h3>
            </div>
            <a href="<?= BASEURL ?>/menu" class="hidden md:flex items-center text-primary font-semibold hover:text-cyan-700 transition">
                Lihat Menu Lengkap <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
            </a>
        </div>
        
        <!-- Horizontal Scrolling Container -->
        <div class="relative w-full group/slider">
            <!-- Navigation Buttons -->
            <button id="scroll-left" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 md:-ml-6 z-30 w-12 h-12 bg-white rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition opacity-0 group-hover/slider:opacity-100 hidden sm:flex">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="scroll-right" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-2 md:-mr-6 z-30 w-12 h-12 bg-white rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition opacity-0 group-hover/slider:opacity-100 hidden sm:flex">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div id="menu-scroll-container" class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory hide-scrollbar scroll-smooth">
                <?php if (isset($data['topFoods']) && count($data['topFoods']) > 0): ?>
                    <?php foreach ($data['topFoods'] as $food): ?>
                        <div class="min-w-[300px] sm:min-w-[350px] w-[300px] sm:w-[350px] flex-shrink-0 snap-start bg-white rounded-2xl shadow-sm hover:shadow-xl transition flex flex-col overflow-hidden group">
                            <div class="relative h-56 overflow-hidden">
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition z-10"></div>
                                <?php 
                                    $imgUrl = BASEURL . '/images/foods/' . htmlspecialchars($food['image_name']);
                                    $fallbackImg = "https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80";
                                ?>
                                <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($food['name']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.src='<?= $fallbackImg ?>'">
                                <span class="absolute top-4 right-4 bg-white text-secondary font-bold px-3 py-1 rounded-full shadow z-20">Rp <?= number_format($food['price'], 0, ',', '.') ?></span>
                            </div>
                            <div class="p-6 flex-grow flex flex-col">
                                <h4 class="text-xl font-bold text-gray-800 mb-2 truncate" title="<?= htmlspecialchars($food['name']) ?>"><?= htmlspecialchars($food['name']) ?></h4>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-3 flex-grow"><?= htmlspecialchars($food['description']) ?></p>
                                <div class="mt-auto">
                                    <form action="<?= BASEURL ?>/customer/addToCart" method="POST">
                                        <input type="hidden" name="food_id" value="<?= $food['food_id'] ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="w-full py-3 border-2 border-primary text-primary font-semibold rounded-xl hover:bg-primary hover:text-white transition flex items-center justify-center gap-2">
                                            <i class="fas fa-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">Tidak ada menu populer yang ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Auto Scroll Script and Dynamic Hero -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Menu Auto Scroll Logic ---
        const container = document.getElementById('menu-scroll-container');
        const scrollLeftBtn = document.getElementById('scroll-left');
        const scrollRightBtn = document.getElementById('scroll-right');
        
        if (container) {
            const scrollAmount = 350 + 24; // Card width + gap approx
            let autoScrollInterval;

            const startAutoScroll = () => {
                autoScrollInterval = setInterval(() => {
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                        container.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    }
                }, 3000);
            };

            const stopAutoScroll = () => clearInterval(autoScrollInterval);

            startAutoScroll();

            // Pause auto scroll on hover/interaction
            container.addEventListener('mouseenter', stopAutoScroll);
            container.addEventListener('mouseleave', startAutoScroll);
            container.addEventListener('touchstart', stopAutoScroll, {passive: true});
            container.addEventListener('touchend', startAutoScroll, {passive: true});

            scrollLeftBtn?.addEventListener('mouseenter', stopAutoScroll);
            scrollLeftBtn?.addEventListener('mouseleave', startAutoScroll);
            scrollRightBtn?.addEventListener('mouseenter', stopAutoScroll);
            scrollRightBtn?.addEventListener('mouseleave', startAutoScroll);

            // Button clicks
            scrollLeftBtn?.addEventListener('click', () => {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });

            scrollRightBtn?.addEventListener('click', () => {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        }

        // --- Dynamic Hero Background Logic ---
        const heroBgContainer = document.getElementById('hero-bg-container');
        if (heroBgContainer) {
            const baseUrl = '<?= BASEURL ?>';
            const images = [
                baseUrl + '/images/aesthetic/home-bg.jpg',
                baseUrl + '/images/aesthetic/00.jpg',
                baseUrl + '/images/aesthetic/01.jpg',
                baseUrl + '/images/aesthetic/02.jpg',
                baseUrl + '/images/aesthetic/03.jpg',
                baseUrl + '/images/aesthetic/04.jpg',
                baseUrl + '/images/aesthetic/05.jpg'
            ];
            
            // Create image layers
            const layers = images.map((src, index) => {
                const div = document.createElement('div');
                div.className = `absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out bg-zoom ${index === 0 ? 'opacity-100' : 'opacity-0'}`;
                div.style.backgroundImage = `url('${src}')`;
                heroBgContainer.appendChild(div);
                return div;
            });

            let currentImageIndex = 0;

            setInterval(() => {
                const nextIndex = (currentImageIndex + 1) % images.length;
                layers[currentImageIndex].classList.replace('opacity-100', 'opacity-0');
                layers[nextIndex].classList.replace('opacity-0', 'opacity-100');
                currentImageIndex = nextIndex;
            }, 5000);
        }
    });
</script>

<!-- Floating CSS Animations and Utilities -->
<style>
    @keyframes zoomBackground {
        0% { transform: scale(1); }
        100% { transform: scale(1.15); }
    }
    .bg-zoom {
        animation: zoomBackground 10s linear infinite alternate;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    
    /* Hide scrollbar for Chrome, Safari and Opera */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .hide-scrollbar {
        -ms-overflow-style: none;     /* IE and Edge */
        scrollbar-width: none;        /* Firefox */
    }
</style>

<?php include '../app/views/layouts/footer.php'; ?>

