<?php include '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="relative bg-secondary text-white pt-20 pb-16 overflow-hidden">
    <!-- Decorative background blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[150%] bg-gradient-to-b from-primary to-transparent rounded-full blur-3xl transform rotate-45"></div>
        <div class="absolute top-[40%] -left-[20%] w-[60%] h-[100%] bg-gradient-to-t from-cyan-600 to-transparent rounded-full blur-3xl transform -rotate-12"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4"><?= htmlspecialchars($title) ?></h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Jelajahi pilihan hidangan premium buatan kami yang dirancang untuk memberi Anda pengalaman kuliner yang tak terlupakan.</p>
    </div>
</div>

<!-- Main Layout -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Sidebar (Filters & Search) -->
            <div class="lg:w-1/4 flex-shrink-0 space-y-8">
                
                <!-- Search Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6" data-aos="fade-right" data-aos-delay="100">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-4">Cari Menu</h3>
                    <form id="search-form" action="<?= BASEURL ?>/menu/fetchFoods" method="GET">
                        <div class="relative">
                            <input type="text" id="search-input" name="q" value="<?= htmlspecialchars($search_keyword ?? '') ?>" placeholder="Cari nama atau deskripsi..." class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition text-sm">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="hidden" id="sort-hidden" name="sort" value="<?= htmlspecialchars($active_sort) ?>">
                            <input type="hidden" id="category-hidden" name="category" value="<?= htmlspecialchars($active_category) ?>">
                        </div>
                        <button type="submit" class="hidden">Cari</button>
                    </form>
                </div>

                <!-- Categories Vertical -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24" data-aos="fade-right" data-aos-delay="200">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-4">Kategori</h3>
                    <div class="space-y-0 lg:space-y-2 flex flex-row lg:flex-col overflow-x-auto lg:overflow-visible gap-3 lg:gap-0 pb-2 lg:pb-0 category-list hide-scrollbar">
                        <a href="javascript:void(0)" data-category="all" class="category-link flex-shrink-0 block px-4 py-3 rounded-xl text-sm font-medium transition <?= ($active_category === 'all') ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-700' ?>">
                            Semua Menu
                        </a>
                        <?php foreach($categories as $cat): ?>
                            <a href="javascript:void(0)" data-category="<?= htmlspecialchars($cat['category']) ?>" class="category-link flex-shrink-0 block px-4 py-3 rounded-xl text-sm font-medium transition <?= ($active_category === $cat['category']) ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-700' ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Right Content (Top Controls & Food Grid) -->
            <div class="lg:w-3/4 flex-grow flex flex-col" data-aos="fade-up" data-aos-delay="300">
                
                <!-- Sort Controls & Result Count -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 px-2">
                    <div class="text-gray-600 text-sm font-medium" id="result-count-text">
                        Menampilkan <span class="font-bold text-gray-900"><?= count($foods) ?></span> menu 
                        <?php if(!empty($search_keyword)): ?>
                            untuk pencarian "<span class="italic font-bold text-secondary"><?= htmlspecialchars($search_keyword) ?></span>"
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-gray-500 font-medium whitespace-nowrap">Urutkan:</label>
                        <select id="sort-select" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 shadow-sm outline-none cursor-pointer">
                            <option value="newest" <?= $active_sort === 'newest' ? 'selected' : '' ?>>Terbaru</option>
                            <option value="price_asc" <?= $active_sort === 'price_asc' ? 'selected' : '' ?>>Harga: Rendah ke Tinggi</option>
                            <option value="price_desc" <?= $active_sort === 'price_desc' ? 'selected' : '' ?>>Harga: Tinggi ke Rendah</option>
                        </select>
                    </div>
                </div>

                <!-- Grid Container -->
                <div id="food-grid-container" class="relative">
                    <?php if(empty($foods)): ?>
                        <div class="text-center py-20 px-4 text-gray-500 bg-white rounded-3xl border border-gray-100 shadow-sm flex-grow flex flex-col items-center justify-center">
                            <div class="relative w-32 h-32 mb-6 group cursor-pointer" onclick="resetFilters()">
                                <div class="absolute inset-0 bg-red-50 rounded-full scale-100 group-hover:scale-110 transition-transform duration-500"></div>
                                <div class="absolute inset-0 flex items-center justify-center text-red-400">
                                    <i class="fas fa-hamburger text-5xl transform -rotate-12 group-hover:rotate-0 transition-transform duration-300"></i>
                                </div>
                                <div class="absolute top-0 right-0 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
                                    <i class="fas fa-question text-red-500 font-bold"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-black text-gray-800 mb-2">Ups! Menu Tidak Ditemukan</h3>
                            <p class="text-gray-500 max-w-sm mb-8 leading-relaxed">Kami tidak dapat menemukan hidangan yang Anda cari. Coba gunakan kata kunci berbeda atau hapus filter yang ada.</p>
                            <button type="button" onclick="resetFilters()" class="text-white bg-primary hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-bold rounded-2xl text-sm px-8 py-3.5 text-center shadow-lg shadow-cyan-500/30 transition-all hover:-translate-y-1">
                                <i class="fas fa-sync-alt mr-2"></i> Tampilkan Semua Menu
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach($foods as $food): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/50 hover:shadow-2xl hover:border-cyan-100 transition-all duration-300 flex flex-col overflow-hidden group transform hover:-translate-y-1 cursor-pointer food-card"
                             data-name="<?= htmlspecialchars($food['name']) ?>"
                             data-price="Rp <?= number_format($food['price'] ?? 0, 0, ',', '.') ?>"
                             data-image="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($food['image_name']) ?>"
                             data-description="<?= htmlspecialchars($food['description']) ?>">
                            <div class="relative h-64 overflow-hidden bg-gray-100">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent group-hover:from-gray-900/60 transition-all z-10"></div>
                                <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($food['image_name']) ?>" alt="<?= htmlspecialchars($food['name']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($food['name'] ?? 'Food') ?>&background=random&color=fff'">
                                <div class="absolute bottom-4 left-4 z-20">
                                    <span class="bg-white text-secondary font-black px-4 py-1.5 rounded-full shadow-lg text-lg ring-4 ring-white/30 truncate block max-w-full">
                                        Rp <?= number_format($food['price'] ?? 0, 0, ',', '.') ?>
                                    </span>
                                </div>
                            </div>
                            <div class="p-6 flex-grow flex flex-col relative bg-white">
                                <div class="mb-4 flex-grow">
                                    <h4 class="text-xl font-bold text-gray-800 leading-tight group-hover:text-cyan-700 transition-colors line-clamp-2"><?= htmlspecialchars($food['name']) ?></h4>
                                </div>
                                <div class="mt-auto pt-4 border-t border-gray-50">
                                    <form class="add-to-cart-form">
                                        <input type="hidden" name="food_id" value="<?= $food['food_id'] ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="add-to-cart-btn w-full py-2.5 bg-gray-50 border border-gray-200 text-secondary font-semibold text-sm rounded-xl hover:bg-primary hover:border-primary hover:text-white transition-all flex items-center justify-center gap-2 group/btn relative overflow-hidden">
                                            <span class="relative z-10 flex items-center gap-2 btn-text"><i class="fas fa-cart-plus text-base"></i> Tambah Keranjang</span>
                                            <div class="absolute inset-0 h-full w-0 bg-primary transition-all duration-300 ease-out group-hover/btn:w-full z-0"></div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const baseUrl = '<?= BASEURL ?>';
    let isFetching = false;

    // --- State Variables ---
    let currentCategory = document.getElementById('category-hidden').value || 'all';
    let currentSort = document.getElementById('sort-select').value || 'newest';
    let currentQuery = document.getElementById('search-input').value || '';

    // --- DOM Elements ---
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const sortSelect = document.getElementById('sort-select');
    const categoryLinks = document.querySelectorAll('.category-link');
    const gridContainer = document.getElementById('food-grid-container');
    const resultCountText = document.getElementById('result-count-text');

    // --- Event Listeners ---
    
    // 1. Search Form Submit
    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        currentQuery = searchInput.value.trim();
        updateMenuURL();
        fetchMenuData();
    });

    // Handle typing delay for search (debounce)
    let typingTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(typingTimer);
        currentQuery = searchInput.value;
        typingTimer = setTimeout(() => {
            updateMenuURL();
            fetchMenuData();
        }, 500); // 500ms debounce
    });

    // 2. Sort Select Change
    sortSelect.addEventListener('change', (e) => {
        currentSort = e.target.value;
        document.getElementById('sort-hidden').value = currentSort;
        updateMenuURL();
        fetchMenuData();
    });

    // 3. Category Click
    categoryLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const cat = link.getAttribute('data-category');
            if(currentCategory === cat) return; // ignore if same
            
            // Update active styling
            categoryLinks.forEach(l => {
                l.className = 'category-link block px-4 py-3 rounded-xl text-sm font-medium transition text-gray-600 hover:bg-cyan-50 hover:text-cyan-700';
            });
            link.className = 'category-link block px-4 py-3 rounded-xl text-sm font-medium transition bg-primary text-white shadow-md';
            
            currentCategory = cat;
            document.getElementById('category-hidden').value = currentCategory;
            
            // Optionally clear search when changing category for better UX
            // currentQuery = '';
            // searchInput.value = '';

            updateMenuURL();
            fetchMenuData();
        });
    });

    // URL Update without refresh
    function updateMenuURL() {
        const url = new URL(baseUrl + '/menu' + (currentCategory !== 'all' ? '/category/' + currentCategory : ''));
        if (currentQuery) url.searchParams.set('q', currentQuery);
        if (currentSort && currentSort !== 'newest') url.searchParams.set('sort', currentSort);
        window.history.pushState({}, '', url);
    }

    // Reset Filters Function
    window.resetFilters = function() {
        currentQuery = '';
        searchInput.value = '';
        currentCategory = 'all';
        currentSort = 'newest';
        sortSelect.value = 'newest';
        
        categoryLinks.forEach(l => {
             l.className = 'category-link block px-4 py-3 rounded-xl text-sm font-medium transition text-gray-600 hover:bg-cyan-50 hover:text-cyan-700';
             if(l.getAttribute('data-category') === 'all') {
                 l.className = 'category-link block px-4 py-3 rounded-xl text-sm font-medium transition bg-primary text-white shadow-md';
             }
        });
        
        updateMenuURL();
        fetchMenuData();
    };


    // --- Core Fetch Logic ---
    function fetchMenuData() {
        if(isFetching) return;
        isFetching = true;

        // Show loading state
        gridContainer.classList.add('opacity-50', 'pointer-events-none', 'scale-[0.98]', 'transition-all', 'duration-300');
        
        // Show loading Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'info',
            title: 'Menerapkan filter...'
        });

        const params = new URLSearchParams({
            q: currentQuery,
            sort: currentSort,
            category: currentCategory
        });

        fetch(`${baseUrl}/menu/fetchFoods?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                renderFoods(data);
            })
            .catch(error => {
                console.error("Failed to fetch menu:", error);
                Swal.fire({icon: 'error', title: 'Oops', text: 'Gagal mengambil data menu'});
            })
            .finally(() => {
                isFetching = false;
                gridContainer.classList.remove('opacity-50', 'pointer-events-none', 'scale-[0.98]');
            });
    }

    // --- Render Logic ---
    function renderFoods(data) {
        // Update Count Text
        let countHtml = `Menampilkan <span class="font-bold text-gray-900">${data.count}</span> menu`;
        if (currentQuery) {
            countHtml += ` untuk pencarian "<span class="italic font-bold text-secondary">${escapeHtml(currentQuery)}</span>"`;
        }
        resultCountText.innerHTML = countHtml;

        if (data.count === 0) {
            gridContainer.innerHTML = `
                <div class="text-center py-20 text-gray-500 bg-white rounded-3xl border border-gray-100 shadow-sm flex-grow flex flex-col items-center justify-center animate-fade-in-up">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-search text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Menu tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci lain atau hapus filter kategori.</p>
                    <button type="button" onclick="resetFilters()" class="mt-6 px-6 py-2.5 bg-primary text-white font-semibold rounded-full hover:bg-cyan-700 transition">Reset Pencarian</button>
                </div>
            `;
            return;
        }

        let html = '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">';
        data.foods.forEach((food, index) => {
            const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(food.price);
            html += `
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/50 hover:shadow-2xl hover:border-cyan-100 transition-all duration-300 flex flex-col overflow-hidden group transform hover:-translate-y-1 cursor-pointer food-card food-item-anim"
                     style="animation-delay: ${index * 50}ms;"
                     data-name="${escapeHtml(food.name)}"
                     data-price="${priceFormatted}"
                     data-image="${data.baseurl}/images/foods/${escapeHtml(food.image_name)}"
                     data-description="${escapeHtml(food.description)}">
                    <div class="relative h-64 overflow-hidden bg-gray-100">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent group-hover:from-gray-900/60 transition-all z-10"></div>
                        <img src="${data.baseurl}/images/foods/${escapeHtml(food.image_name)}" alt="${escapeHtml(food.name)}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(food.name)}&background=random&color=fff'">
                        <div class="absolute bottom-4 left-4 z-20">
                            <span class="bg-white text-secondary font-black px-4 py-1.5 rounded-full shadow-lg text-lg ring-4 ring-white/30 truncate block max-w-full">
                                ${priceFormatted}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col relative bg-white">
                        <div class="mb-4 flex-grow">
                            <h4 class="text-xl font-bold text-gray-800 leading-tight group-hover:text-cyan-700 transition-colors line-clamp-2">${escapeHtml(food.name)}</h4>
                        </div>
                        <div class="mt-auto pt-4 border-t border-gray-50">
                            <form class="add-to-cart-form">
                                <input type="hidden" name="food_id" value="${food.food_id}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="add-to-cart-btn w-full py-2.5 bg-gray-50 border border-gray-200 text-secondary font-semibold text-sm rounded-xl hover:bg-primary hover:border-primary hover:text-white transition-all flex items-center justify-center gap-2 group/btn relative overflow-hidden">
                                    <span class="relative z-10 flex items-center gap-2 btn-text"><i class="fas fa-cart-plus text-base"></i> Tambah Keranjang</span>
                                    <div class="absolute inset-0 h-full w-0 bg-primary transition-all duration-300 ease-out group-hover/btn:w-full z-0"></div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        gridContainer.innerHTML = html;
        
        // Re-attach event listeners to new cards
        attachCardListeners();
    }

    // --- Detail Popup and Add to Cart Logic ---
    function attachCardListeners() {
        // Detailed Popup
        document.querySelectorAll('.food-card').forEach(card => {
            card.addEventListener('click', (e) => {
                if (e.target.closest('form')) return;

                const name = card.getAttribute('data-name');
                const price = card.getAttribute('data-price');
                const img = card.getAttribute('data-image');
                const desc = card.getAttribute('data-description');

                Swal.fire({
                    html: `
                        <div class="text-left mt-2">
                            <img src="${img}" class="w-full h-64 object-cover rounded-2xl mb-6 shadow-sm bg-gray-100" alt="${name}" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&color=fff'">
                            <h2 class="text-2xl font-black text-gray-800 mb-2">${name}</h2>
                            <p class="text-primary font-bold text-xl mb-4">${price}</p>
                            <div class="w-12 h-1 bg-gray-200 rounded-full mb-4"></div>
                            <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-wrap">${desc}</p>
                        </div>
                    `,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup Detail',
                    confirmButtonColor: '#2D3748',
                    customClass: {
                        popup: 'rounded-[2rem] p-2',
                        confirmButton: 'rounded-full px-8 py-3 font-semibold'
                    }
                });
            });
        });

        // Add to Cart AJAX
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                <?php if(!isset($_SESSION['user_id'])): ?>
                    window.location.href = baseUrl + '/auth/login';
                    return;
                <?php endif; ?>

                const formData = new FormData(form);
                const btn = form.querySelector('.add-to-cart-btn');
                const btnText = form.querySelector('.btn-text');
                
                // Loading state
                const originalText = btnText.innerHTML;
                btnText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                btn.disabled = true;

                fetch(`${baseUrl}/customer/addToCart`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    // if response is a redirect (e.g. not logged in), fetch handles it transparently but the url changes
                    if(response.redirected) {
                        window.location.href = response.url;
                        return null;
                    }
                    return response.json();
                })
                .then(data => {
                    if(!data) return;
                    if(data.status === 'success') {
                        // Toast Notification
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });

                        // Update badges
                        const badge = document.getElementById('nav-cart-badge');
                        const mobileBadge = document.getElementById('mobile-nav-cart-badge');
                        
                        if(badge) {
                            badge.textContent = data.cart_count;
                        } else {
                            // Badge doesn't exist yet, we could reload or manually inject it into the DOM,
                            // but since the wrapper is complex, relying on the badge existing (even if hidden) is easier.
                            // If it doesn't exist we force a reload just in case, or we fetch the generic navbar.
                            // For Gresda Food, we modified navbar.php to always render it if >0, we can just reload if it is exactly 0 to 1 transition.
                            if(data.cart_count === 1) {
                                window.location.reload(); 
                            }
                        }
                        
                        if(mobileBadge) {
                            mobileBadge.textContent = data.cart_count;
                        }

                    } else {
                        Swal.fire('Oops', data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(err => console.error("Error adding to cart:", err))
                .finally(() => {
                    btnText.innerHTML = originalText;
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                    btn.disabled = false;
                });
            });
        });
    }

    // Helper to escape HTML to prevent XSS in JS template literals
    function escapeHtml(unsafe) {
        if(!unsafe) return '';
        return unsafe.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Initialize listners on page load
    document.addEventListener('DOMContentLoaded', () => {
        attachCardListeners();
    });
</script>

<style>
    /* Hide scrollbar for category menu but allow scrolling */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

    /* Custom Animation for Food Cards Entrance */
    @keyframes fadeInUpStagger {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .food-item-anim {
        animation: fadeInUpStagger 0.6s ease-out forwards;
        opacity: 0; /* starts transparent */
    }
</style>

<?php include '../app/views/layouts/footer.php'; ?>
