<?php include '../app/views/layouts/header.php'; ?>

<?php 
// Ensure $food is available
if (!isset($food) || empty($food)):
?>
<div class="bg-gray-50 min-h-screen flex items-center justify-center">
    <p class="text-gray-500 text-lg">Menu tidak ditemukan.</p>
</div>
<?php else: ?>

<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center text-sm text-gray-500 gap-2">
            <a href="<?= BASEURL ?>" class="hover:text-primary transition">Beranda</a>
            <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            <a href="<?= BASEURL ?>/menu" class="hover:text-primary transition">Menu</a>
            <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            <span class="text-gray-800 font-semibold"><?= htmlspecialchars($food['name']) ?></span>
        </nav>
    </div>
</div>

<!-- Product Detail -->
<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Image Section -->
                <div class="relative h-80 lg:h-full min-h-[400px] bg-gray-100">
                    <img src="<?= BASEURL ?>/uploads/food/<?= htmlspecialchars($food['image'] ?? 'default.jpg') ?>" 
                         alt="<?= htmlspecialchars($food['name']) ?>" 
                         class="w-full h-full object-cover"
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($food['name']) ?>&background=random&color=fff&size=400'">
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <?php if (!empty($food['is_bestseller'])): ?>
                            <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                <i class="fas fa-fire mr-1"></i> Best Seller
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($food['is_new'])): ?>
                            <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                <i class="fas fa-sparkles mr-1"></i> Baru
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($food['is_spicy'])): ?>
                            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                <i class="fas fa-pepper-hot mr-1"></i> Pedas
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="p-8 lg:p-12 flex flex-col">
                    <div class="flex-grow">
                        <!-- Category -->
                        <?php if (!empty($food['category_name'])): ?>
                            <span class="text-primary text-sm font-bold uppercase tracking-widest mb-3 block">
                                <?= htmlspecialchars($food['category_name']) ?>
                            </span>
                        <?php endif; ?>

                        <!-- Name -->
                        <h1 class="text-3xl lg:text-4xl font-black text-gray-900 mb-4 leading-tight">
                            <?= htmlspecialchars($food['name']) ?>
                        </h1>

                        <!-- Price -->
                        <div class="flex items-center gap-3 mb-8">
                            <span class="text-3xl font-extrabold text-primary">
                                Rp <?= number_format($food['price'] ?? 0, 0, ',', '.') ?>
                            </span>
                            <?php if (!empty($food['weight'])): ?>
                                <span class="text-sm text-gray-400 font-medium bg-gray-100 px-3 py-1 rounded-full">
                                    <?= htmlspecialchars($food['weight']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Divider -->
                        <div class="w-16 h-1 bg-gray-200 rounded-full mb-6"></div>

                        <!-- Description -->
                        <div class="prose prose-gray max-w-none mb-8">
                            <p class="text-gray-600 leading-relaxed whitespace-pre-wrap">
                                <?= htmlspecialchars($food['description'] ?? 'Deskripsi belum tersedia.') ?>
                            </p>
                        </div>
                    </div>

                    <!-- Add to Cart -->
                    <div class="mt-auto">
                        <form action="<?= BASEURL ?>/customer/addToCart" method="POST" class="flex items-center gap-4">
                            <?= CSRF::getTokenField() ?>
                            <input type="hidden" name="food_id" value="<?= htmlspecialchars($food['id']) ?>">
                            
                            <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 h-12">
                                <button type="button" onclick="changeQty(-1)" class="px-4 text-gray-500 hover:text-primary transition font-bold text-lg">−</button>
                                <input type="number" name="qty" id="qty-input" value="1" min="1" max="99" class="w-14 text-center bg-transparent border-none focus:ring-0 text-lg font-bold">
                                <button type="button" onclick="changeQty(1)" class="px-4 text-gray-500 hover:text-primary transition font-bold text-lg">+</button>
                            </div>

                            <button type="submit" class="flex-1 py-3.5 bg-primary text-white rounded-xl font-bold text-lg hover:bg-cyan-700 transition shadow-lg shadow-cyan-500/30 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Items -->
        <?php if (!empty($related) && count($related) > 1): ?>
        <div class="mt-16">
            <h2 class="text-2xl font-black text-gray-900 mb-8">Menu Serupa</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($related as $item): ?>
                    <?php if ($item['id'] === $food['id']) continue; // Skip current item ?>
                    <a href="<?= BASEURL ?>/menu/detail/<?= htmlspecialchars($item['id']) ?>" 
                       class="bg-white rounded-2xl shadow-sm border border-gray-100/50 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            <img src="<?= BASEURL ?>/uploads/food/<?= htmlspecialchars($item['image'] ?? 'default.jpg') ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($item['name']) ?>&background=random&color=fff'">
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 mb-1 line-clamp-1 group-hover:text-primary transition-colors">
                                <?= htmlspecialchars($item['name']) ?>
                            </h4>
                            <p class="text-primary font-extrabold">
                                Rp <?= number_format($item['price'] ?? 0, 0, ',', '.') ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function changeQty(delta) {
    const input = document.getElementById('qty-input');
    let val = parseInt(input.value) || 1;
    val = Math.max(1, Math.min(99, val + delta));
    input.value = val;
}
</script>

<?php endif; ?>

<?php include '../app/views/layouts/footer.php'; ?>
