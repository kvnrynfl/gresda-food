<?php include '../app/views/layouts/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="<?= BASEURL ?>/customer/orders" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 shadow-sm border border-gray-200 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="bg-primary/10 border-b border-primary/20 px-8 py-6 flex flex-col sm:flex-row justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-primary uppercase tracking-wider mb-1">ID Pesanan</p>
                    <h2 class="text-2xl font-bold text-gray-900 font-mono">#<?= htmlspecialchars($order_id) ?></h2>
                </div>
            </div>
            
            <div class="p-8">
                <?php if(empty($details)): ?>
                    <div class="text-center py-10">
                        <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Tidak ada rincian pesanan yang dapat ditampilkan.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-6">
                        <?php 
                        $totalPrice = 0;
                        foreach($details as $item): 
                            // Note: We use original price without multiplier here
                            $subtotal = ($item['price'] ?? 0) * ($item['qty'] ?? 1);
                            $totalPrice += $subtotal;
                        ?>
                            <div class="flex items-center justify-between border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden shadow-sm flex-shrink-0">
                                        <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($item['image_name'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($item['name'] ?? 'Menu') ?>" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($item['name'] ?? 'Item') ?></h4>
                                        <p class="text-sm text-gray-500 font-medium">
                                            <?= htmlspecialchars($item['qty'] ?? 1) ?>x @ Rp <?= number_format($item['price'] ?? 0, 0, ',', '.') ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-gray-900 text-lg">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if(!empty($details)): ?>
            <div class="bg-gray-50 p-8 border-t border-gray-100">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-medium text-gray-600">Subtotal Item</span>
                    <span class="font-bold text-gray-800">Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="font-medium text-gray-600">Pajak (10%)</span>
                    <span class="font-bold text-gray-800">Rp <?= number_format($totalPrice * 0.1, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <span class="font-medium text-gray-600">Pengiriman</span>
                    <span class="font-bold text-gray-800">Rp 15.000</span>
                </div>
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <span class="text-xl font-bold text-gray-900">Total Keseluruhan</span>
                    <span class="text-3xl font-extrabold text-primary">Rp <?= number_format(($totalPrice * 1.1) + 15000, 0, ',', '.') ?></span>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>
