<?php include '../app/views/layouts/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center gap-3 mb-8 text-sm text-gray-500 font-medium">
            <a href="<?= BASEURL ?>/customer/cart" class="hover:text-primary transition"><i class="fas fa-shopping-cart"></i> Keranjang</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900">Pembayaran</span>
        </div>

        <h2 class="text-3xl font-extrabold text-secondary mb-8">Selesaikan Pembayaran</h2>

        <form id="checkout-form" action="<?= BASEURL ?>/customer/processCheckout" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <?= CSRF::getTokenField() ?>
            
            <div class="lg:col-span-2 space-y-8">
                <!-- Shipping Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-map-marker-alt text-primary"></i> Detail Pengiriman</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Rekening Pengirim</label>
                            <input type="text" name="rekening_name" required value="<?= htmlspecialchars($_SESSION['username']) ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition" placeholder="Contoh: Budi Santoso">
                            <span class="text-xs text-gray-500 mt-1 block">Nama pada rekening bank atau dompet digital yang digunakan untuk transfer.</span>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap Pengiriman</label>
                            <textarea name="address" rows="3" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-wallet text-primary"></i> Metode Pembayaran</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <?php if(isset($data['payment_methods']) && !empty($data['payment_methods'])): foreach($data['payment_methods'] as $index => $pm): ?>
                        <label class="relative border border-gray-200 rounded-xl p-4 flex flex-col items-center cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-cyan-50 transition">
                            <input type="radio" name="payment_method" value="<?= htmlspecialchars($pm['metode']) ?>" class="absolute opacity-0 peer" required <?php echo ($index == 0) ? 'checked' : ''; ?>>
                            <div class="w-full h-full absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary pointer-events-none"></div>
                            <img src="<?= BASEURL ?>/images/payment/<?= htmlspecialchars($pm['image_name']) ?>" alt="<?= htmlspecialchars($pm['metode']) ?>" class="h-8 mb-2 object-contain" onerror="this.src='https://via.placeholder.com/80x30?text=<?= urlencode($pm['metode']) ?>'">
                            <span class="text-sm font-medium text-gray-700 text-center mt-2"><?= htmlspecialchars($pm['metode']) ?></span>
                        </label>
                        <?php endforeach; else: ?>
                            <div class="col-span-full text-center text-red-500 py-4 bg-red-50 rounded-lg">
                                Belum ada metode pembayaran yang tersedia.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 mb-6">
                        <p class="text-sm tracking-wide text-gray-600 mb-2">Silakan transfer ke nomor rekening berikut setelah pesanan dibuat:</p>
                        <p class="text-xl font-mono font-bold text-gray-900 tracking-wider">1234 5678 9012 3456</p>
                        <p class="text-sm font-semibold text-gray-500">A/N Gresda Food & Beverage</p>
                    </div>
                </div>
            </div>

            <!-- Validation Action & Order Summary -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Selected Items Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-hidden">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3 flex items-center justify-between">
                        <span>Ringkasan Pesanan</span>
                        <span class="text-sm font-semibold text-primary"><?= count($data['checkout_items'] ?? []) ?> Item</span>
                    </h3>
                    <div class="space-y-4 max-h-64 overflow-y-auto pr-2 mb-4">
                        <?php 
                        $totalPrice = 0;
                        if(isset($data['checkout_items']) && !empty($data['checkout_items'])): 
                            foreach($data['checkout_items'] as $item): 
                                $sub = $item['price'] * $item['qty'];
                                $totalPrice += $sub;
                        ?>
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($item['image_name']) ?>" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-800 leading-tight"><?= htmlspecialchars($item['name']) ?></h4>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-xs font-semibold text-gray-500"><?= $item['qty'] ?>x Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
                                        <span class="text-sm font-bold text-secondary">Rp <?= number_format($sub, 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endforeach; 
                        endif; 
                        $tax = $totalPrice * 0.1;
                        $shipping = isset($data['checkout_items']) && count($data['checkout_items']) > 0 ? 15000 : 0;
                        $grandTotal = $totalPrice + $tax + $shipping;
                        ?>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-3 space-y-2 text-sm inline-block w-full">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-800">Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Pajak (10%)</span>
                            <span class="font-medium text-gray-800">Rp <?= number_format($tax, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Pengiriman</span>
                            <span class="font-medium text-gray-800">Rp <?= number_format($shipping, 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-gray-800">Total Pembayaran</span>
                            <span class="text-xl font-black text-primary">Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Konfirmasi Akhir</h3>
                    
                    <button type="button" onclick="confirmCheckout();" class="w-full flex justify-center items-center py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-cyan-700 transition shadow-lg gap-2 shadow-cyan-500/30">
                        <i class="fas fa-shopping-bag"></i> Buat Pesanan Sekarang
                    </button>
                    
                    <div class="mt-6 text-xs text-gray-400 text-center leading-relaxed">
                        Dengan menyelesaikan pesanan ini, Anda menyetujui <a href="#" class="text-primary hover:underline">Ketentuan Layanan</a> dan <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a> kami.
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
function confirmCheckout() {
    var form = document.getElementById('checkout-form');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    Swal.fire({
        title: 'Buat Pesanan?',
        text: "Pesanan akan dibuat dan Anda dapat melakukan pembayaran setelahnya.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#06b6d4',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Buat Pesanan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

<?php include '../app/views/layouts/footer.php'; ?>

