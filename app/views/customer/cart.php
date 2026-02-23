<?php include '../app/views/layouts/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center gap-3 mb-8 text-sm text-gray-500 font-medium">
            <a href="<?= BASEURL ?>/" class="hover:text-primary transition"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900">Keranjang Belanja</span>
        </div>

        <h2 class="text-3xl font-extrabold text-secondary mb-8">Keranjang Anda</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <?php if (empty($cart_items)): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6 text-gray-300">
                            <i class="fas fa-shopping-basket text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Anda kosong</h3>
                        <p class="text-gray-500 mb-6">Sepertinya Anda belum menambahkan apa pun ke keranjang Anda.</p>
                        <a href="<?= BASEURL ?>/menu" class="px-8 py-3 bg-primary text-white font-bold rounded-full hover:bg-cyan-700 transition shadow-md inline-flex items-center gap-2">
                            <i class="fas fa-hamburger"></i> Jelajahi Menu
                        </a>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Table header hidden on mobile -->
                        <div class="hidden sm:grid grid-cols-12 gap-4 p-6 bg-gray-50 border-b border-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="col-span-6">Produk</div>
                            <div class="col-span-2 text-center">Harga</div>
                            <div class="col-span-2 text-center">Kuantitas</div>
                            <div class="col-span-2 text-right">Subtotal</div>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <?php 
                                $totalPrice = 0;
                                foreach($cart_items as $item): 
                                    $subtotal = $item['price'] * $item['qty'];
                                    $totalPrice += $subtotal;
                            ?>
                                <div class="p-6 grid grid-cols-1 sm:grid-cols-12 gap-6 relative items-center group">
                                    <div class="col-span-1 sm:col-span-6 flex gap-4 items-center">
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($item['image_name']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($item['name']) ?></h4>
                                            <p class="text-sm text-gray-500 line-clamp-1">Item reference.</p>
                                        </div>
                                    </div>
                                    <div class="col-span-1 sm:col-span-2 flex justify-between sm:justify-center items-center">
                                        <span class="sm:hidden font-semibold text-gray-500">Harga:</span>
                                        <span class="text-gray-700 font-medium">Rp <?= number_format($item['price'] ?? 0, 0, ',', '.') ?></span>
                                    </div>
                                    <div class="col-span-1 sm:col-span-2 flex justify-between sm:justify-center items-center">
                                        <span class="sm:hidden font-semibold text-gray-500">Kuantitas:</span>
                                        <!-- Real app needs ajax qty update here -->
                                        <form action="<?= BASEURL ?>/customer/updateCartQty" method="POST" class="flex items-center border border-gray-200 rounded-lg bg-gray-50 h-10 w-24">
                                            <?= CSRF::getTokenField() ?>
                                            <input type="hidden" name="food_id" value="<?= $item['food_id'] ?>">
                                            <button type="submit" name="action" value="decrease" class="px-3 hover:text-primary transition font-bold" <?= $item['qty'] <= 1 ? 'disabled class="opacity-50 cursor-not-allowed"' : '' ?>>-</button>
                                            <input type="text" value="<?= $item['qty'] ?>" class="w-full text-center bg-transparent border-none focus:ring-0 text-sm font-semibold p-0" readonly>
                                            <button type="submit" name="action" value="increase" class="px-3 hover:text-primary transition font-bold">+</button>
                                        </form>
                                    </div>
                                    <div class="col-span-1 sm:col-span-2 flex justify-between sm:justify-end items-center">
                                        <span class="sm:hidden font-semibold text-gray-500">Subtotal:</span>
                                        <span class="text-secondary font-bold text-lg">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="absolute top-4 right-4 sm:-right-4 sm:top-auto sm:opacity-0 group-hover:opacity-100 group-hover:right-4 transition-all">
                                        <form action="<?= BASEURL ?>/customer/removeFromCart" method="POST">
                                            <?= CSRF::getTokenField() ?>
                                            <input type="hidden" name="food_id" value="<?= $item['food_id'] ?>">
                                            <button type="submit" class="w-8 h-8 bg-cyan-100 text-cyan-500 rounded-full flex items-center justify-center hover:bg-cyan-500 hover:text-white" title="Hapus item">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Order Summary -->
            <?php if (!empty($cart_items)): ?>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium text-gray-800">Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Pajak (10%)</span>
                                <span class="font-medium text-gray-800">Rp <?= number_format($totalPrice * 0.1, 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Pengiriman</span>
                                <span class="font-medium text-gray-800">Rp 15.000</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-3xl font-extrabold text-primary">Rp <?= number_format(($totalPrice * 1.1) + 15000, 0, ',', '.') ?></span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-right">Termasuk pajak & pengiriman</p>
                        </div>

                        <a href="<?= BASEURL ?>/customer/checkout" class="w-full flex justify-center items-center py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-cyan-700 transition shadow-lg gap-2 shadow-cyan-500/30">
                            Lanjutkan ke Pembayaran <i class="fas fa-arrow-right"></i>
                        </a>

                        <div class="mt-6 text-center flex items-center justify-center gap-3 text-gray-400">
                            <i class="fab fa-cc-visa text-2xl"></i>
                            <i class="fab fa-cc-mastercard text-2xl"></i>
                            <i class="fab fa-cc-paypal text-2xl"></i>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>

