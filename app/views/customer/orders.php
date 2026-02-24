<?php 
$title = "Pesanan Saya";
include '../app/views/layouts/header.php'; 
?>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-5xl">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="<?= BASEURL ?>/customer/profile" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 shadow-sm border border-gray-200 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
        </div>

        <div class="space-y-6">
            <?php if(!empty($orders)): foreach($orders as $order): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 hover:shadow-lg transition-all duration-300 group">
                    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6 pb-6 border-b border-gray-50">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-cyan-50 flex items-center justify-center text-primary">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">ID Pesanan</p>
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors">#<?= htmlspecialchars($order['order_id']) ?></h3>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 flex items-center gap-2 mt-4 md:mt-0">
                                <i class="far fa-clock"></i> <?= date('d M Y - H:i', strtotime($order['created_at'])) ?>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <?php 
                                $statusClass = 'bg-gray-100 text-gray-600 border-gray-200';
                                $statusIcon = 'fa-clock';
                                $statusMap = [
                                    'Cart' => 'Keranjang',
                                    'Payment' => 'Menunggu Pembayaran',
                                    'Confirmed' => 'Dikonfirmasi',
                                    'Delivery' => 'Sedang Dikirim',
                                    'Finished' => 'Selesai',
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
                            <span class="inline-flex items-center gap-2 <?= $statusClass ?> px-4 py-2 rounded-full font-bold text-sm border shadow-sm">
                                <i class="fas <?= $statusIcon ?>"></i> <?= htmlspecialchars($statusText) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="w-full md:w-auto text-left">
                            <p class="text-sm text-gray-500 font-medium mb-1">Total Pembayaran</p>
                            <p class="text-3xl font-black text-gray-800">Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?></p>
                        </div>
                        <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                            <?php if($order['status'] === 'Payment'): ?>
                            <a href="<?= BASEURL ?>/customer/payment/<?= urlencode($order['order_id']) ?>" class="w-full sm:w-auto px-8 py-3.5 bg-red-500 border-2 border-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 hover:border-red-600 transition-all shadow-lg shadow-red-500/30 active:scale-95 flex items-center justify-center gap-2 relative">
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-400 rounded-full animate-ping"></span>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-600 border-2 border-white rounded-full"></span>
                                <i class="fas fa-wallet"></i> Bayar Sekarang
                            </a>
                            <?php endif; ?>
                            <a href="<?= BASEURL ?>/customer/orderDetails/<?= urlencode($order['order_id']) ?>" class="w-full sm:w-auto px-8 py-3.5 bg-white border-2 border-primary text-primary text-sm font-bold rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm hover:shadow active:scale-95 flex items-center justify-center gap-2">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-16 text-center">
                    <div class="w-28 h-28 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 border-8 border-white shadow-sm">
                        <i class="fas fa-shopping-bag text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Riwayat Pesanan</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto leading-relaxed">Tampaknya Anda belum melakukan pesanan apa pun. Mari jelajahi menu lezat kami dan buat pesanan pertama Anda hari ini!</p>
                    <a href="<?= BASEURL ?>/menu" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary text-white rounded-full font-bold text-lg hover:bg-cyan-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                        <i class="fas fa-utensils"></i> Ayo Mulai Memesan
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>


