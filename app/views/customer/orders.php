<?php 
$page_title = "Riwayat Pesanan";
$back_link = BASEURL . "/customer/profile";
$hide_card = true;
ob_start(); 
?>

<div class="space-y-6">
    <?php if(!empty($orders)): foreach($orders as $order): ?>
        <?php ob_start(); ?>
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
                        $statusVariant = 'gray';
                        $statusIcon = 'fas fa-clock';
                        $statusMap = [
                            'Cart' => 'Keranjang',
                            'Payment' => 'Menunggu Pembayaran',
                            'Confirmed' => 'Dikonfirmasi',
                            'Delivery' => 'Sedang Dikirim',
                            'Finished' => 'Selesai',
                            'Canceled' => 'Dibatalkan'
                        ];
                        switch($order['status']) {
                            case 'Cart': $statusVariant = 'gray'; $statusIcon = 'fas fa-shopping-cart'; break;
                            case 'Payment': $statusVariant = 'info'; $statusIcon = 'fas fa-wallet'; break;
                            case 'Confirmed': $statusVariant = 'info'; $statusIcon = 'fas fa-check-circle'; break;
                            case 'Delivery': $statusVariant = 'warning'; $statusIcon = 'fas fa-motorcycle'; break;
                            case 'Finished': $statusVariant = 'success'; $statusIcon = 'fas fa-flag-checkered'; break;
                            case 'Canceled': $statusVariant = 'danger'; $statusIcon = 'fas fa-times-circle'; break;
                        }
                        $statusText = $statusMap[$order['status']] ?? $order['status'];
                        
                        $props = ['text' => $statusText, 'variant' => $statusVariant, 'icon' => $statusIcon, 'class' => 'px-4 py-2 text-sm'];
                        include '../app/views/components/ui/badge.php';
                    ?>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="w-full md:w-auto text-left">
                    <p class="text-sm text-gray-500 font-medium mb-1">Total Pembayaran</p>
                    <p class="text-3xl font-black text-gray-800">Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?></p>
                </div>
                <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                    <?php if($order['status'] === 'Payment'): ?>
                        <?php 
                        $props = [
                            'text' => 'Bayar Sekarang', 
                            'type' => 'a', 
                            'href' => BASEURL . '/customer/payment/' . urlencode($order['order_id']), 
                            'variant' => 'danger', 
                            'icon' => 'fas fa-wallet', 
                            'class' => 'w-full sm:w-auto'
                        ];
                        include '../app/views/components/ui/button.php';
                        ?>
                    <?php endif; ?>
                    <?php 
                    $props = [
                        'text' => 'Detail', 
                        'type' => 'a', 
                        'href' => BASEURL . '/customer/orderDetails/' . urlencode($order['order_id']), 
                        'variant' => 'outline', 
                        'class' => 'w-full sm:w-auto'
                    ];
                    include '../app/views/components/ui/button.php';
                    ?>
                </div>
            </div>
        <?php 
        $slot = ob_get_clean();
        $props = ['class' => 'hover:shadow-lg transition-all duration-300 group', 'body_class' => 'p-6 md:p-8'];
        include '../app/views/components/ui/card.php';
        ?>
    <?php endforeach; else: ?>
        <?php ob_start(); ?>
        <div class="text-center py-8">
            <div class="w-28 h-28 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 border-8 border-white shadow-sm">
                <i class="fas fa-shopping-bag text-5xl text-gray-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Riwayat Pesanan</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto leading-relaxed">Tampaknya Anda belum melakukan pesanan apa pun. Mari jelajahi menu lezat kami dan buat pesanan pertama Anda hari ini!</p>
            <?php 
            $props = ['text' => 'Ayo Mulai Memesan', 'type' => 'a', 'href' => BASEURL . '/menu', 'variant' => 'primary', 'icon' => 'fas fa-utensils', 'class' => 'rounded-full px-8 py-4 text-lg'];
            include '../app/views/components/ui/button.php';
            ?>
        </div>
        <?php 
        $slot = ob_get_clean();
        $props = ['class' => 'p-8'];
        include '../app/views/components/ui/card.php';
        ?>
    <?php endif; ?>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>


