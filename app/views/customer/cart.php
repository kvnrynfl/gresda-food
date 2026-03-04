<?php 
$page_title = "Keranjang Belanja";
$back_link = BASEURL . "/menu";
$hide_card = true;
ob_start(); 
?>

<form id="checkout-form" action="<?= BASEURL ?>/customer/checkoutSelected" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <?= CSRF::getTokenField() ?>
    <!-- Cart Items -->
    <?php $cartColSpan = empty($cart_items) ? 'lg:col-span-3' : 'lg:col-span-2'; ?>
    <div class="<?= $cartColSpan ?>">
        <?php if (empty($cart_items)): ?>
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 md:p-20 text-center flex flex-col items-center justify-center min-h-[60vh] mx-auto w-full" data-aos="zoom-in">
                <div class="relative w-40 h-40 mb-8 group cursor-pointer" onclick="window.location.href='<?= BASEURL ?>/menu'">
                    <div class="absolute inset-0 bg-cyan-50 rounded-full scale-100 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-cyan-400">
                        <i class="fas fa-shopping-cart text-6xl transform -rotate-12 group-hover:rotate-0 transition-transform duration-300"></i>
                    </div>
                    <div class="absolute top-0 right-0 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-exclamation text-xl text-primary font-bold"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-800 mb-4 tracking-tight">Keranjang Anda Masih Kosong</h3>
                <p class="text-gray-500 text-lg max-w-md mx-auto mb-10 leading-relaxed">Sepertinya Anda belum menambahkan hidangan apa pun ke keranjang Anda. Yuk, lihat menu spesial dari kami!</p>
                <a href="<?= BASEURL ?>/menu" class="px-10 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-cyan-700 transition-all hover:-translate-y-1 shadow-xl shadow-cyan-500/30 inline-flex items-center gap-3 text-lg">
                    <i class="fas fa-hamburger"></i> Jelajahi Menu
                </a>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Table header hidden on mobile -->
                <div class="hidden sm:grid grid-cols-12 gap-4 p-6 bg-gray-50 border-b border-gray-100 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                    <div class="col-span-6 flex items-center gap-4">
                        <input type="checkbox" id="check-all" class="w-5 h-5 text-primary rounded border-gray-300 focus:ring-primary" checked onchange="toggleAll(this)">
                        <span>Produk</span>
                    </div>
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
                                <input type="checkbox" name="selected_items[]" value="<?= $item['id'] ?>" class="item-checkbox w-5 h-5 text-primary rounded border-gray-300 focus:ring-primary" checked data-price="<?= $item['price'] ?>" data-qty="<?= $item['qty'] ?>" onchange="updateTotal()">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="<?= BASEURL ?>/uploads/food/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($item['name']) ?></h4>
                                </div>
                            </div>
                            <div class="col-span-1 sm:col-span-2 flex justify-between sm:justify-center items-center">
                                <span class="sm:hidden font-semibold text-gray-500">Harga:</span>
                                <span class="text-gray-700 font-medium">Rp <?= number_format($item['price'] ?? 0, 0, ',', '.') ?></span>
                            </div>
                            <div class="col-span-1 sm:col-span-2 flex justify-between sm:justify-center items-center">
                                <span class="sm:hidden font-semibold text-gray-500">Kuantitas:</span>
                                <!-- Real app needs ajax qty update here -->
                                <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50 h-10 w-24">
                                    <button type="button" onclick="submitAction('<?= BASEURL ?>/customer/updateCartQty', '<?= $item['food_id'] ?>', 'decrease')" class="px-3 hover:text-primary transition font-bold" <?= $item['qty'] <= 1 ? 'disabled class="opacity-50 cursor-not-allowed"' : '' ?>>-</button>
                                    <input type="text" value="<?= $item['qty'] ?>" class="w-full text-center bg-transparent border-none focus:ring-0 text-sm font-semibold p-0" readonly>
                                    <button type="button" onclick="submitAction('<?= BASEURL ?>/customer/updateCartQty', '<?= $item['food_id'] ?>', 'increase')" class="px-3 hover:text-primary transition font-bold">+</button>
                                </div>
                            </div>
                            <div class="col-span-1 sm:col-span-2 flex justify-between sm:justify-end items-center">
                                <span class="sm:hidden font-semibold text-gray-500">Subtotal:</span>
                                <span class="text-secondary font-bold text-lg">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>

                            <!-- Remove Button -->
                            <div class="absolute top-4 right-4 sm:-right-4 sm:top-auto sm:opacity-0 group-hover:opacity-100 group-hover:right-4 transition-all">
                                <button type="button" onclick="submitAction('<?= BASEURL ?>/customer/removeFromCart', '<?= $item['food_id'] ?>', '')" class="w-8 h-8 bg-cyan-100 text-cyan-500 rounded-full flex items-center justify-center hover:bg-cyan-500 hover:text-white" title="Hapus item">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
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
                        <span id="summary-subtotal" class="font-medium text-gray-800">Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Pajak (10%)</span>
                        <span id="summary-tax" class="font-medium text-gray-800">Rp <?= number_format($totalPrice * 0.1, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Pengiriman</span>
                        <span id="summary-shipping" class="font-medium text-gray-800">Rp 15.000</span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total</span>
                        <span id="summary-total" class="text-3xl font-extrabold text-primary">Rp <?= number_format(($totalPrice * 1.1) + 15000, 0, ',', '.') ?></span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 text-right">Termasuk pajak & pengiriman</p>
                </div>

                <button id="btn-checkout" type="submit" class="w-full flex justify-center items-center py-4 bg-primary text-white rounded-xl font-bold text-lg hover:bg-cyan-700 transition shadow-lg gap-2 shadow-cyan-500/30">
                    Lanjutkan ke Pembayaran <i class="fas fa-arrow-right"></i>
                </button>

                <div class="mt-6 text-center flex items-center justify-center gap-3 text-gray-400">
                    <i class="fab fa-cc-visa text-2xl"></i>
                    <i class="fab fa-cc-mastercard text-2xl"></i>
                    <i class="fab fa-cc-paypal text-2xl"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>

<!-- Hidden Action Form -->
<form id="action-form" action="" method="POST" class="hidden">
    <?= CSRF::getTokenField() ?>
    <input type="hidden" name="food_id" id="action-food-id" value="">
    <input type="hidden" name="action" id="action-type" value="">
</form>

<script>
function submitAction(url, foodId, actionType = '') {
    const form = document.getElementById('action-form');
    form.action = url;
    document.getElementById('action-food-id').value = foodId;
    document.getElementById('action-type').value = actionType;
    form.submit();
}

function toggleAll(source) {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = source.checked;
    });
    updateTotal();
}

function updateTotal() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    let subtotal = 0;
    let checkedCount = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) {
            subtotal += (parseFloat(cb.dataset.price) * parseInt(cb.dataset.qty));
            checkedCount++;
        }
    });

    const tax = subtotal * 0.1;
    const shipping = checkedCount > 0 ? 15000 : 0;
    const grandTotal = subtotal + tax + shipping;

    document.getElementById('summary-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('summary-tax').innerText = 'Rp ' + tax.toLocaleString('id-ID');
    document.getElementById('summary-shipping').innerText = 'Rp ' + shipping.toLocaleString('id-ID');
    document.getElementById('summary-total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');

    const btn = document.getElementById('btn-checkout');
    if (checkedCount === 0) {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}
</script>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>

