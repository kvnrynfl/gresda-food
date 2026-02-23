<?php include '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="bg-secondary text-white pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4"><?= htmlspecialchars($title) ?></h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Jelajahi pilihan hidangan premium buatan kami yang dirancang untuk memberi Anda pengalaman kuliner yang tak terlupakan.</p>
    </div>
</div>

<!-- Category Filters -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex overflow-x-auto py-4 gap-2 scrollbar-hide snap-x">
            <a href="<?= BASEURL ?>/menu" class="whitespace-nowrap px-6 py-2 rounded-full font-medium transition <?= ($active_category === 'all') ? 'bg-primary text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                Semua Kategori
            </a>
            <?php foreach($categories as $cat): ?>
                <a href="<?= BASEURL ?>/menu/category/<?= urlencode($cat['category']) ?>" class="whitespace-nowrap px-6 py-2 rounded-full font-medium transition <?= ($active_category === $cat['category']) ? 'bg-primary text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Main Menu Grid -->
<section class="py-16 bg-gray-50 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if(empty($foods)): ?>
            <div class="text-center py-20 text-gray-500">
                <i class="fas fa-search text-6xl mb-4 text-gray-300"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Tidak ada makanan ditemukan</h3>
                <p>Kami tidak dapat menemukan item apa pun dalam kategori ini.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach($foods as $food): ?>
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition flex flex-col overflow-hidden group">
                        <div class="relative h-56 overflow-hidden">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition z-10"></div>
                            <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($food['image_name']) ?>" alt="<?= htmlspecialchars($food['name']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.src='https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80'">
                            <span class="absolute top-4 right-4 bg-white text-secondary font-bold px-3 py-1 rounded-full shadow z-20">Rp <?= number_format($food['price'], 0, ',', '.') ?></span>
                        </div>
                        <div class="p-6 flex-grow flex flex-col">
                            <h4 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($food['name']) ?></h4>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-3"><?= htmlspecialchars($food['description']) ?></p>
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <form action="<?= BASEURL ?>/customer/addToCart" method="POST">
                                    <input type="hidden" name="food_id" value="<?= $food['food_id'] ?>">
                                    <button type="submit" class="w-full py-3 bg-white border border-primary text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition flex items-center justify-center gap-2 group-hover:shadow-md">
                                        <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

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
</style>

<?php include '../app/views/layouts/footer.php'; ?>
