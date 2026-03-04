<?php 
$page_title = "Profil Akun";
$back_link = BASEURL . "/";
$hide_card = true;
ob_start(); 

// Calculate Quick Stats
$totalOrders = is_array($recent_orders) ? count($recent_orders) : 0;
$activeOrders = 0;
$finishedOrders = 0;
$totalSpent = 0;

if(is_array($recent_orders)) {
    foreach($recent_orders as $o) {
        if(in_array($o['status'], ['pending_payment', 'confirmed', 'processing', 'delivering'])) {
            $activeOrders++;
        }
        if($o['status'] === 'finished') {
            $finishedOrders++;
            $totalSpent += ($o['grand_total'] ?? 0);
        }
    }
}
?>

<!-- Welcome Banner -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
    <div class="bg-gradient-to-r from-cyan-600 to-primary h-40 relative flex items-center px-8 sm:px-32">
        <div class="absolute -bottom-12 left-8">
            <img src="<?= BASEURL ?>/images/users/<?= htmlspecialchars($user['img_user'] ?? 'default.jpg') ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user['username'] ?? 'User') ?>&background=E53E3E&color=fff'" alt="Profile" class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg bg-white">
        </div>
    </div>
    <div class="pt-16 pb-8 px-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($user['username'] ?? 'Customer') ?></h2>
            <p class="text-gray-500 flex items-center gap-2 mt-1">
                <i class="fas fa-envelope text-primary"></i> <?= htmlspecialchars($user['email'] ?? 'example@email.com') ?>
            </p>
        </div>
        <div>
            <a href="<?= BASEURL ?>/customer/editProfile" class="px-5 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 border border-gray-300 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-cyan-50 text-primary rounded-full flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Total Pesanan</p>
            <p class="text-2xl font-black text-gray-800"><?= number_format($totalOrders) ?></p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-motorcycle"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Sedang Proses</p>
            <p class="text-2xl font-black text-gray-800"><?= number_format($activeOrders) ?></p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pesanan Selesai</p>
            <p class="text-2xl font-black text-gray-800"><?= number_format($finishedOrders) ?></p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl flex-shrink-0">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="overflow-hidden">
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Total Belanja</p>
            <p class="text-lg font-black text-gray-800 tracking-tight truncate">Rp <?= number_format($totalSpent, 0, ',', '.') ?></p>
        </div>
    </div>
</div>

<!-- Dashboard Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Order History Minimal -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-history text-primary"></i> Pesanan Terbaru</h3>
            <a href="<?= BASEURL ?>/customer/orders" class="text-primary text-sm font-semibold hover:underline">Lihat Semua</a>
        </div>
        
        <div class="space-y-4">
            <?php if(!empty($recent_orders)): ?>
                <?php 
                // Only show the top 3 recent orders
                $displayOrders = array_slice($recent_orders, 0, 3);
                foreach($displayOrders as $order): 
                    $statusClass = 'text-gray-500 bg-gray-100';
                    $statusMap = [
                        'pending_payment' => 'Pembayaran',
                        'confirmed' => 'Dikonfirmasi',
                        'processing' => 'Diproses',
                        'delivering' => 'Dikirim',
                        'finished' => 'Selesai',
                        'cancelled' => 'Dibatalkan'
                    ];
                    switch($order['status']) {
                        case 'pending_payment': $statusClass = 'text-blue-700 bg-blue-100'; break;
                        case 'confirmed': $statusClass = 'text-indigo-700 bg-indigo-100'; break;
                        case 'processing': $statusClass = 'text-violet-700 bg-violet-100'; break;
                        case 'delivering': $statusClass = 'text-orange-700 bg-orange-100'; break;
                        case 'finished': $statusClass = 'text-green-700 bg-green-100'; break;
                        case 'cancelled': $statusClass = 'text-red-700 bg-red-100'; break;
                    }
                    $statusText = $statusMap[$order['status']] ?? $order['status'];
                ?>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 hover:bg-cyan-50 transition cursor-pointer group" onclick="window.location.href='<?= BASEURL ?>/customer/orderDetails/<?= urlencode($order['id']) ?>'">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center text-primary border border-gray-200 group-hover:border-cyan-200">
                            <i class="fas fa-shopping-bag text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Pesanan <?= htmlspecialchars($order['order_number'] ?? substr($order['id'], 0, 8)) ?></h4>
                            <p class="text-xs text-gray-500"><?= date('d M Y', strtotime($order['created_at'] ?? 'now')) ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 <?= $statusClass ?> rounded-full text-xs font-bold mb-1"><?= htmlspecialchars($statusText) ?></span>
                        <p class="font-bold text-gray-800">Rp <?= number_format($order['grand_total'] ?? 0, 0, ',', '.') ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- If no orders -->
                <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-gray-100">
                        <i class="fas fa-shopping-bag text-4xl text-gray-300"></i>
                    </div>
                    <p class="font-bold text-gray-700 mb-2 text-lg">Belum Ada Pesanan</p>
                    <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">Jelajahi menu lezat kami dan buat pesanan pertama Anda untuk memanjakan lidah.</p>
                    <a href="<?= BASEURL ?>/menu" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-semibold flex-shrink-0 rounded-xl hover:bg-cyan-700 transition shadow hover:-translate-y-0.5">
                        <i class="fas fa-utensils text-sm"></i> Jelajahi Menu Kami
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="space-y-6">
        <!-- Shopping Cart -->
        <div class="bg-gradient-to-br from-cyan-500 to-primary text-white rounded-2xl shadow-lg p-6 relative overflow-hidden group hover:scale-[1.02] transition duration-300 cursor-pointer" onclick="window.location.href='<?= BASEURL ?>/customer/cart'">
            <i class="fas fa-shopping-cart absolute -bottom-4 -right-4 text-8xl text-white opacity-20 group-hover:scale-110 group-hover:-rotate-12 transition duration-500"></i>
            <div class="relative z-10">
                <h4 class="text-xl font-extrabold mb-1 drop-shadow-sm">Keranjang Belanja</h4>
                <p class="text-cyan-50 text-sm mb-6 drop-shadow-sm">Anda memiliki <?= $cart_count ?? 0 ?> item lezat yang menunggu.</p>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-4xl font-black drop-shadow-md"><?= $cart_count ?? 0 ?></span>
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:bg-white/30 transition">
                        <i class="fas fa-arrow-right text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Review Reminder -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0 mt-1">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 mb-1">Berikan Ulasan</h4>
                <p class="text-sm text-gray-500 mb-3">Bantu kami untuk lebih baik dengan meninjau pesanan Anda sebelumnya.</p>
                <a href="<?= BASEURL ?>/customer/reviews" class="text-sm font-semibold text-primary hover:text-cyan-700">Tulis Ulasan</a>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>


