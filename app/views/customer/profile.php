<?php include '../app/views/layouts/header.php'; ?>

<div class="bg-gray-100 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Banner -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8 mt-8">
            <div class="bg-gradient-to-r from-secondary to-gray-800 h-32 relative">
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
                    <a href="<?= BASEURL ?>/customer/editProfile" class="px-5 py-2 bg-gray-100 text-secondary hover:bg-gray-200 border border-gray-300 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
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
                                'Cart' => 'Keranjang',
                                'Payment' => 'Pembayaran',
                                'Confirmed' => 'Dikonfirmasi',
                                'Delivery' => 'Dikirim',
                                'Finished' => 'Selesai',
                                'Canceled' => 'Dibatalkan'
                            ];
                            switch($order['status']) {
                                case 'Payment': $statusClass = 'text-blue-700 bg-blue-100'; break;
                                case 'Confirmed': $statusClass = 'text-indigo-700 bg-indigo-100'; break;
                                case 'Delivery': $statusClass = 'text-orange-700 bg-orange-100'; break;
                                case 'Finished': $statusClass = 'text-green-700 bg-green-100'; break;
                                case 'Canceled': $statusClass = 'text-cyan-700 bg-cyan-100'; break;
                            }
                            $statusText = $statusMap[$order['status']] ?? $order['status'];
                        ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 hover:bg-cyan-50 transition cursor-pointer group" onclick="window.location.href='<?= BASEURL ?>/customer/orderDetails/<?= urlencode($order['order_id']) ?>'">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-lg shadow-sm flex items-center justify-center text-primary border border-gray-200 group-hover:border-cyan-200">
                                    <i class="fas fa-shopping-bag text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Pesanan #<?= htmlspecialchars($order['order_id']) ?></h4>
                                    <p class="text-xs text-gray-500"><?= date('d M Y', strtotime($order['tgl_order'] ?? 'now')) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 <?= $statusClass ?> rounded-full text-xs font-bold mb-1"><?= htmlspecialchars($statusText) ?></span>
                                <p class="font-bold text-gray-800">Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- If no orders -->
                        <div class="text-center py-12 text-gray-400">
                            <i class="fas fa-box-open text-5xl mb-4 text-gray-200"></i>
                            <p>Anda belum membuat pesanan apa pun.</p>
                            <a href="<?= BASEURL ?>/#menu" class="text-primary hover:underline mt-2 inline-block font-semibold">Mulai jelajahi menu</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="space-y-6">
                <!-- Shopping Cart -->
                <div class="bg-primary text-white rounded-2xl shadow-lg p-6 relative overflow-hidden group hover:scale-[1.02] transition cursor-pointer" onclick="window.location.href='<?= BASEURL ?>/customer/cart'">
                    <i class="fas fa-shopping-cart absolute -bottom-6 -right-6 text-9xl text-white opacity-10 group-hover:scale-110 transition duration-500"></i>
                    <div class="relative z-10">
                        <h4 class="text-xl font-bold mb-1">Keranjang Saya</h4>
                        <p class="text-cyan-100 text-sm mb-4">Anda memiliki <?= $cart_count ?? 0 ?> item di keranjang Anda.</p>
                        <div class="flex items-center justify-between items-end mt-4">
                            <span class="text-3xl font-extrabold flex items-center gap-1"><i class="fas fa-box-open text-lg opacity-80"></i> <?= $cart_count ?? 0 ?></span>
                            <i class="fas fa-arrow-right text-white"></i>
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

    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>


