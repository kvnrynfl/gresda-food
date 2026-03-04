<?php $title = 'Home'; ?>
<?php include '../app/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="relative bg-secondary text-white min-h-screen flex items-center justify-center pt-16">
    <!-- Dynamic Background Image Container -->
    <div id="hero-bg-container" class="absolute inset-0 z-0 overflow-hidden">
        <!-- JS will inject layers here -->
    </div>

    <div class="absolute inset-0 z-10 bg-black/70 flex"></div>
    
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center w-full">
        <div class="flex flex-col items-center max-w-4xl">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)] animate-fade-in-up" data-aos="zoom-out-down" data-aos-duration="1000">
                Pengalaman <span class="text-primary italic">Rasa Premium</span> 
                <br>Keunggulan Kuliner
            </h1>
            <p class="text-xl text-gray-300 mb-10 drop-shadow-md" data-aos="fade-up" data-aos-delay="300">
                Gresda Food & Beverage menawarkan hidangan steak kelas dunia, sajian barat yang lezat, dan suasana yang menenangkan.
            </p>
        <div class="flex flex-col sm:flex-row gap-4 mt-4" data-aos="fade-up" data-aos-delay="500">
            <a href="menu" class="px-6 py-3 bg-primary text-white rounded-full font-semibold text-base hover:bg-cyan-700 hover:scale-105 transition transform shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-utensils"></i> Lihat Menu
            </a>
            <a href="<?= BASEURL ?>/about" class="px-6 py-3 bg-white/90 text-secondary rounded-full font-semibold text-base hover:bg-white hover:scale-105 transition transform shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-info-circle"></i> Temukan Info Lebih Lanjut
            </a>
        </div>
        </div>
    </div>
</section>

<!-- Features / About Section Summary -->
<section id="about" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <div class="lg:w-1/2 relative" data-aos="fade-right">
                <div class="absolute -inset-4 bg-cyan-100 rounded-3xl transform -rotate-3 z-0"></div>
                <img src="<?= BASEURL ?>/images/aesthetic/01.jpg" alt="Tentang Gresda Food" class="relative z-10 rounded-2xl shadow-xl w-full object-cover h-[450px]" onerror="this.src='https://ui-avatars.com/api/?name=Gresda+Food&background=random&color=fff'">
                <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-2xl shadow-xl z-20 flex items-center gap-4 hidden sm:flex animate-float">
                    <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center text-2xl font-bold">5+</div>
                    <div>
                        <p class="font-bold text-secondary">Tahun</p>
                        <p class="text-sm text-gray-500">Pengalaman Kuliner</p>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2 text-left mt-16 lg:mt-0" data-aos="fade-left" data-aos-delay="200">
                <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">Tentang Kami</h2>
                <h3 class="text-4xl md:text-5xl font-extrabold text-secondary mb-6 leading-tight">Pengalaman Bersantap tak Terlupakan</h3>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    Lebih dari sekadar restoran, Gresda Food & Beverage adalah tempat di mana momen indah diciptakan. Sejak hari pertama, kami berkomitmen untuk menyajikan hidangan yang tidak hanya memuaskan lidah, tapi juga menghangatkan hati.
                </p>
                <div class="space-y-4 mb-10">
                    <div class="flex items-start gap-4" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-check-circle text-primary text-xl mt-1"></i>
                        <p class="text-gray-700"><strong>Bahan Baku Pilihan:</strong> Kami secara ketat menyeleksi daging sapi impor terbaik dan sayuran organik segar setiap harinya.</p>
                    </div>
                    <div class="flex items-start gap-4" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-check-circle text-primary text-xl mt-1"></i>
                        <p class="text-gray-700"><strong>Koki Berpengalaman:</strong> Dikerjakan oleh tenaga profesional yang menaruh nyawa pada setiap hidangan.</p>
                    </div>
                </div>
                <a href="<?= BASEURL ?>/about" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-full font-bold text-lg hover:bg-cyan-700 transition transform shadow hover:scale-105" data-aos="zoom-in" data-aos-delay="500">
                    Kenali Kami Lebih Dekat <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
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
        <div class="relative w-full group/slider" data-aos="fade-up" data-aos-duration="1000">
            <!-- Navigation Buttons -->
            <button id="scroll-left" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 md:-ml-6 z-30 w-12 h-12 bg-white rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition opacity-0 group-hover/slider:opacity-100 hidden sm:flex">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="scroll-right" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-2 md:-mr-6 z-30 w-12 h-12 bg-white rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition opacity-0 group-hover/slider:opacity-100 hidden sm:flex">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div id="menu-scroll-container" class="flex overflow-x-auto gap-6 pb-8 hide-scrollbar pt-4 px-2">
                <?php if (isset($topFoods) && count($topFoods) > 0): ?>
                    <?php $delay = 100; foreach ($topFoods as $food): ?>
                        <div class="min-w-[300px] sm:min-w-[350px] w-[300px] sm:w-[350px] flex-shrink-0 snap-start bg-white rounded-2xl shadow-sm hover:shadow-xl transition flex flex-col overflow-hidden group" data-aos="zoom-in" data-aos-delay="<?= $delay ?>">
                            <div class="relative h-56 overflow-hidden">
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition z-10"></div>
                                <?php 
                                    $imgUrl = BASEURL . '/uploads/food/' . htmlspecialchars($food['image']);
                                ?>
                                <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($food['name']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($food['name']) ?>&background=random&color=fff'">
                                <span class="absolute top-4 right-4 bg-white text-secondary font-bold px-3 py-1 rounded-full shadow z-20">Rp <?= number_format($food['price'] ?? 0, 0, ',', '.') ?></span>
                            </div>
                            <div class="p-6 flex-grow flex flex-col">
                                <h4 class="text-xl font-bold text-gray-800 mb-2 truncate" title="<?= htmlspecialchars($food['name']) ?>"><?= htmlspecialchars($food['name']) ?></h4>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-3 flex-grow"><?= htmlspecialchars($food['description']) ?></p>
                                <div class="mt-auto">
                                    <form action="<?= BASEURL ?>/customer/addToCart" method="POST">
                                        <?= CSRF::getTokenField() ?>
                                        <input type="hidden" name="food_id" value="<?= $food['id'] ?>">
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

<!-- Customer Reviews Section -->
<?php if (isset($reviews) && count($reviews) > 0): ?>
<section id="reviews" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-down" data-aos-duration="800">
            <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">Testimoni</h2>
            <h3 class="text-4xl font-extrabold text-secondary mb-4">Ulasan Pengunjung</h3>
            <p class="text-gray-500 max-w-2xl mx-auto">Lihat apa yang dikatakan pelanggan kami tentang pengalaman bersantap mereka di Gresda Food & Beverage.</p>
        </div>
        
        <div class="relative w-full group/review-slider" data-aos="fade-up" data-aos-duration="1000">
            <button id="review-scroll-left" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 md:-ml-6 z-30 w-12 h-12 bg-white rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition opacity-0 group-hover/review-slider:opacity-100 hidden sm:flex">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="review-scroll-right" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-2 md:-mr-6 z-30 w-12 h-12 bg-white rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition opacity-0 group-hover/review-slider:opacity-100 hidden sm:flex">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div id="review-scroll-container" class="flex overflow-x-auto gap-6 pb-8 pt-4 px-4 hide-scrollbar">
                <?php $rDelay=100; foreach ($reviews as $review): ?>
                <div class="min-w-[300px] md:min-w-[400px] w-[300px] md:w-[400px] flex-shrink-0 snap-center bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition flex flex-col" data-aos="fade-up" data-aos-delay="<?= $rDelay ?>">
                    <div class="flex items-center gap-1 mb-4 text-yellow-500">
                        <?php 
                        $rating = (float)$review['rating'];
                        for($i=1; $i<=5; $i++): 
                            if ($rating >= $i) {
                                echo '<i class="fas fa-star"></i>';
                            } elseif ($rating >= $i - 0.5) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="fas fa-star text-gray-300"></i>';
                            }
                        endfor; 
                        ?>
                    </div>
                    <p class="text-gray-700 italic mb-6 leading-relaxed flex-grow line-clamp-4">"<?= htmlspecialchars($review['message']) ?>"</p>
                    <div class="flex items-center gap-4 mt-auto border-t border-gray-50 pt-4">
                        <img src="<?= BASEURL ?>/images/users/<?= htmlspecialchars($review['img_user'] ?? 'default.jpg') ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($review['username'] ?? 'User') ?>&background=E53E3E&color=fff'" alt="<?= htmlspecialchars($review['username']) ?>" class="w-12 h-12 rounded-full object-cover shadow-sm border-2 border-white">
                        <div>
                            <h4 class="font-bold text-secondary text-base"><?= htmlspecialchars($review['username']) ?></h4>
                            <span class="text-xs text-gray-500 font-medium">Pelanggan Gresda</span>
                        </div>
                    </div>
                </div>
                <?php $rDelay+=100; endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action / Contact Info -->
<section class="py-20 bg-secondary relative overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="<?= BASEURL ?>/images/aesthetic/02.jpg" class="w-full h-full object-cover opacity-20 filter grayscale" alt="Background">
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center text-white" data-aos="zoom-in" data-aos-duration="800">
        <h2 class="text-3xl md:text-5xl font-bold mb-6">Siap Menikmati Hidangan Kami?</h2>
        <p class="text-xl text-gray-300 mb-10">Kunjungi lokasi kami atau hubungi kami untuk reservasi dan pertanyaan lebih lanjut. Kami menantikan kehadiran Anda.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?= BASEURL ?>/contact" class="px-8 py-4 bg-primary text-white rounded-full font-bold text-lg hover:bg-cyan-700 transition shadow-lg inline-flex justify-center items-center gap-2">
                <i class="fas fa-map-marker-alt"></i> Lokasi & Kontak
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="px-8 py-4 bg-green-500 text-white rounded-full font-bold text-lg hover:bg-green-600 transition shadow-lg inline-flex justify-center items-center gap-2">
                <i class="fab fa-whatsapp text-xl"></i> Chat WhatsApp
            </a>
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
            let isHovered = false;
            let scrollSpeed = 1; // pixels per frame

            const autoScroll = () => {
                if (!isHovered) {
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 1) {
                        container.scrollLeft = 0;
                    } else {
                        container.scrollLeft += scrollSpeed;
                    }
                }
                requestAnimationFrame(autoScroll);
            };

            requestAnimationFrame(autoScroll);

            // Pause auto scroll on hover/interaction
            container.addEventListener('mouseenter', () => isHovered = true);
            container.addEventListener('mouseleave', () => isHovered = false);
            container.addEventListener('touchstart', () => isHovered = true, {passive: true});
            container.addEventListener('touchend', () => isHovered = false, {passive: true});

            const scrollAmount = 350 + 24; // Card width + gap approx
            scrollLeftBtn?.addEventListener('mouseenter', () => isHovered = true);
            scrollLeftBtn?.addEventListener('mouseleave', () => isHovered = false);
            scrollRightBtn?.addEventListener('mouseenter', () => isHovered = true);
            scrollRightBtn?.addEventListener('mouseleave', () => isHovered = false);

            scrollLeftBtn?.addEventListener('click', () => {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });

            scrollRightBtn?.addEventListener('click', () => {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        }

        // --- Reviews Auto Scroll Logic ---
        const reviewContainer = document.getElementById('review-scroll-container');
        const revLeftBtn = document.getElementById('review-scroll-left');
        const revRightBtn = document.getElementById('review-scroll-right');
        
        if (reviewContainer) {
            let revIsHovered = false;
            let revScrollSpeed = 1;

            const revAutoScroll = () => {
                if (!revIsHovered) {
                    if (reviewContainer.scrollLeft + reviewContainer.clientWidth >= reviewContainer.scrollWidth - 1) {
                        reviewContainer.scrollLeft = 0;
                    } else {
                        reviewContainer.scrollLeft += revScrollSpeed;
                    }
                }
                requestAnimationFrame(revAutoScroll);
            };

            requestAnimationFrame(revAutoScroll);

            reviewContainer.addEventListener('mouseenter', () => revIsHovered = true);
            reviewContainer.addEventListener('mouseleave', () => revIsHovered = false);
            reviewContainer.addEventListener('touchstart', () => revIsHovered = true, {passive: true});
            reviewContainer.addEventListener('touchend', () => revIsHovered = false, {passive: true});

            const revScrollAmount = 400 + 24; // Card width + gap approx
            revLeftBtn?.addEventListener('mouseenter', () => revIsHovered = true);
            revLeftBtn?.addEventListener('mouseleave', () => revIsHovered = false);
            revRightBtn?.addEventListener('mouseenter', () => revIsHovered = true);
            revRightBtn?.addEventListener('mouseleave', () => revIsHovered = false);

            revLeftBtn?.addEventListener('click', () => {
                reviewContainer.scrollBy({ left: -revScrollAmount, behavior: 'smooth' });
            });
            revRightBtn?.addEventListener('click', () => {
                reviewContainer.scrollBy({ left: revScrollAmount, behavior: 'smooth' });
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

