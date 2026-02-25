<?php 
$page_title = "Detail Pesanan";
$back_link = BASEURL . "/customer/orders";
$hide_card = true;
ob_start(); 
?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6 group">
    <div class="bg-gradient-to-r from-cyan-50 to-white border-b border-gray-100 px-8 py-8 flex flex-col sm:flex-row justify-between sm:items-center gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-white rounded-full shadow-sm border border-gray-100 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                    <i class="fas fa-receipt text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">ID Pesanan</p>
                    <h2 class="text-2xl font-black text-gray-900 font-mono tracking-tight leading-none">#<?= htmlspecialchars($order_id) ?></h2>
                </div>
            </div>
            <?php if(isset($order)): ?>
            <p class="text-sm text-gray-500 font-medium ml-15 mt-2 flex items-center gap-2">
                <i class="far fa-calendar-alt text-primary/70"></i> <?= date('d F Y, H:i', strtotime($order['created_at'])) ?>
            </p>
            <?php endif; ?>
        </div>
        
        <div>
            <?php if(isset($order)): ?>
                <?php 
                    $statusClass = 'bg-gray-100 text-gray-600 border-gray-200';
                    $statusIcon = 'fa-clock';
                    $statusMap = [
                        'Cart' => 'Keranjang',
                        'Payment' => 'Menunggu Pembayaran',
                        'Confirmed' => 'Dikonfirmasi',
                        'Delivery' => 'Sedang Dikirim',
                        'Finished' => 'Pesanan Selesai',
                        'Canceled' => 'Dibatalkan'
                    ];
                    switch($order['status']) {
                        case 'Cart': $statusClass = 'bg-gray-100 text-gray-600 border-gray-200'; $statusIcon = 'fa-shopping-cart'; break;
                        case 'Payment': $statusClass = 'bg-blue-50 text-blue-700 border-blue-200'; $statusIcon = 'fa-wallet'; break;
                        case 'Confirmed': $statusClass = 'bg-indigo-50 text-indigo-700 border-indigo-200'; $statusIcon = 'fa-check-circle'; break;
                        case 'Delivery': $statusClass = 'bg-orange-50 text-orange-700 border-orange-200'; $statusIcon = 'fa-motorcycle'; break;
                        case 'Finished': $statusClass = 'bg-green-50 text-green-700 border-green-200'; $statusIcon = 'fa-flag-checkered'; break;
                        case 'Canceled': $statusClass = 'bg-red-50 text-red-700 border-red-200'; $statusIcon = 'fa-times-circle'; break;
                    }
                    $statusText = $statusMap[$order['status']] ?? $order['status'];
                ?>
                <div class="flex flex-col items-start sm:items-end gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Status Pesanan</span>
                    <span class="inline-flex items-center gap-2 <?= $statusClass ?> px-5 py-2.5 rounded-full font-bold text-sm border shadow-sm">
                        <i class="fas <?= $statusIcon ?>"></i> <?= htmlspecialchars($statusText) ?>
                    </span>
                </div>
            <?php else: ?>
                <div class="text-sm font-bold text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                    <i class="far fa-clock text-primary mr-1"></i> Riwayat Pesanan Anda
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if(isset($order) && $order['status'] !== 'Cart'): ?>
    <?php
        $steps = ['Payment' => 'Menunggu Pembayaran', 'Confirmed' => 'Dikonfirmasi', 'Delivery' => 'Dikirim', 'Finished' => 'Selesai'];
        $currentStatus = $order['status'];
        $isCanceled = ($currentStatus === 'Canceled');
        $statusKeys = array_keys($steps);
        $currentIndex = array_search($currentStatus, $statusKeys);
        if ($currentIndex === false && !$isCanceled) $currentIndex = -1;
    ?>
    <div class="px-4 sm:px-8 py-8 border-b border-gray-100 bg-gray-50/30">
        <div class="max-w-3xl mx-auto">
            <?php if($isCanceled): ?>
                <div class="text-center py-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 text-red-600 mb-3 border-4 border-white shadow-sm">
                        <i class="fas fa-times text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-red-700 text-lg">Pesanan Dibatalkan</h3>
                    <p class="text-gray-500 text-sm mt-1 mb-2">Proses pesanan ini telah dihentikan.</p>
                </div>
            <?php else: ?>
            <div class="relative flex justify-between sm:w-10/12 md:w-full mx-auto pb-8 sm:pb-12">
                <div class="absolute left-0 top-5 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0 rounded-full"></div>
                <div class="absolute left-0 top-5 transform -translate-y-1/2 h-1 bg-primary z-0 rounded-full transition-all duration-1000 ease-out" style="width: <?= $currentIndex > 0 ? ($currentIndex / (count($steps) - 1)) * 100 : 0 ?>%"></div>
                
                <?php foreach($steps as $key => $label): 
                    $stepIndex = array_search($key, $statusKeys);
                    $isCompleted = $stepIndex <= $currentIndex;
                    $isCurrent = $stepIndex === $currentIndex;
                ?>
                <div class="relative z-10 flex flex-col items-center group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-all duration-500 <?= $isCompleted ? 'bg-primary text-white ring-4 ring-cyan-50' : 'bg-white text-gray-400 border-2 border-gray-200' ?> <?= $isCurrent ? 'ring-4 ring-cyan-100 scale-110 !font-extrabold shadow-md' : '' ?>">
                        <?php if($isCompleted): ?>
                            <i class="fas fa-check"></i>
                        <?php else: ?>
                            <?= $stepIndex + 1 ?>
                        <?php endif; ?>
                    </div>
                    <span class="mt-4 text-[11px] sm:text-xs font-semibold <?= $isCurrent ? 'text-primary' : ($isCompleted ? 'text-gray-800' : 'text-gray-400') ?> text-center absolute top-10 whitespace-nowrap <?= $stepIndex === 0 ? '-translate-x-1/4 sm:translate-x-0' : ($stepIndex === count($steps)-1 ? 'translate-x-1/4 sm:translate-x-0' : '') ?>"><?= $label ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
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
                                <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($item['image_name'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($item['name'] ?? 'Menu') ?>" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($item['name'] ?? 'Menu') ?>&background=random&color=fff'">
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
    </div>
    <?php endif; ?>
    
    <?php if(isset($confirm) && !empty($confirm['image_name'])): ?>
    <div class="bg-gray-50 p-8 border-t border-gray-100">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-file-invoice-dollar text-primary"></i> Bukti Pembayaran
        </h3>
        <div class="flex flex-col sm:flex-row gap-8 items-start">
            <div class="w-full sm:w-1/2 bg-white p-2 rounded-2xl border border-gray-200 shadow-sm">
                <img src="<?= BASEURL ?>/images/confirm/<?= htmlspecialchars($confirm['image_name']) ?>" alt="Bukti Pembayaran" class="w-full h-auto rounded-xl max-h-96 object-contain bg-gray-50" onerror="this.src='https://ui-avatars.com/api/?name=Bukti+Pembayaran&background=E53E3E&color=fff'">
            </div>
            <div class="w-full sm:w-1/2 space-y-4">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                    <p class="text-base font-semibold text-gray-800"><?= htmlspecialchars($confirm['payment'] ?? 'Transfer Bank') ?></p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Atas Nama Rekening</p>
                    <p class="text-base font-semibold text-gray-800"><?= htmlspecialchars($confirm['rekening_name'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tanggal Upload</p>
                    <p class="text-base font-semibold text-gray-800">
                        <?= !empty($confirm['tgl_pay']) && $confirm['tgl_pay'] !== '0000-00-00' ? date('d F Y', strtotime($confirm['tgl_pay'])) : 'Belum Diverifikasi' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php elseif(isset($order) && $order['status'] === 'Payment'): ?>
    <div class="bg-red-50 p-8 border-t border-red-100 text-center">
        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-exclamation-triangle text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-red-800 mb-2">Menunggu Bukti Pembayaran</h3>
        <p class="text-red-600 mb-6 max-w-md mx-auto">Kami belum menerima bukti pembayaran untuk pesanan ini. Pesanan tidak akan diproses hingga pembayaran dikonfirmasi.</p>
        <a href="<?= BASEURL ?>/customer/payment/<?= urlencode($order_id) ?>" class="inline-block px-8 py-3 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-500/30 hover:bg-red-700 transition relative">
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-400 rounded-full animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-600 border-2 border-white rounded-full"></span>
            <i class="fas fa-wallet mr-2"></i> Bayar Sekarang
        </a>
    </div>
    <?php endif; ?>

</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
