<?php 
$title = "Detail Pesanan #" . htmlspecialchars($order_id);
include '../app/views/layouts/admin_header.php'; 

$totalPrice = 0;
?>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="<?= BASEURL ?>/admin/orders" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 shadow-sm border border-gray-200 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan Admin</h1>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 px-8 py-6 flex flex-col md:flex-row justify-between md:items-center gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Saat Ini</p>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-black text-gray-900 font-mono tracking-tight leading-none">#<?= htmlspecialchars($order_id) ?></h2>
                        <?php 
                            $statusClass = 'bg-gray-100 text-gray-600 border-gray-200';
                            $statusMap = [
                                'Cart' => 'Keranjang',
                                'Payment' => 'Menunggu Pembayaran',
                                'Confirmed' => 'Dikonfirmasi',
                                'Delivery' => 'Sedang Dikirim',
                                'Finished' => 'Selesai',
                                'Canceled' => 'Dibatalkan'
                            ];
                            switch($order['status']) {
                                case 'Cart': $statusClass = 'bg-gray-100 text-gray-600 border-gray-200'; break;
                                case 'Payment': $statusClass = 'bg-blue-50 text-blue-700 border-blue-200'; break;
                                case 'Confirmed': $statusClass = 'bg-indigo-50 text-indigo-700 border-indigo-200'; break;
                                case 'Delivery': $statusClass = 'bg-orange-50 text-orange-700 border-orange-200'; break;
                                case 'Finished': $statusClass = 'bg-green-50 text-green-700 border-green-200'; break;
                                case 'Canceled': $statusClass = 'bg-red-50 text-red-700 border-red-200'; break;
                            }
                        ?>
                        <span class="inline-flex items-center <?= $statusClass ?> px-3 py-1 rounded-full font-bold text-sm border shadow-sm">
                            <?= htmlspecialchars($statusMap[$order['status']] ?? $order['status']) ?>
                        </span>
                    </div>
                </div>
                <!-- Action Form -->
                <?php if ($order['status'] !== 'Finished' && $order['status'] !== 'Canceled' && $order['status'] !== 'Cart'): ?>
                <form action="<?= BASEURL ?>/admin/updateOrderStatus/<?= urlencode($order_id) ?>" method="POST" class="flex gap-2 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                    <?= CSRF::getTokenField() ?>
                    <select name="status" class="text-sm border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-primary focus:border-primary font-semibold text-gray-700">
                        <option value="Payment" <?= ($order['status'] == 'Payment') ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                        <option value="Confirmed" <?= ($order['status'] == 'Confirmed') ? 'selected' : '' ?>>Dikonfirmasi</option>
                        <option value="Delivery" <?= ($order['status'] == 'Delivery') ? 'selected' : '' ?>>Pengiriman</option>
                        <option value="Finished" <?= ($order['status'] == 'Finished') ? 'selected' : '' ?>>Selesai</option>
                        <option value="Canceled">Batalkan Pesanan</option>
                    </select>
                    <button type="submit" class="bg-primary text-white text-sm px-4 py-2 rounded-lg hover:bg-cyan-600 transition font-bold shadow-md shadow-cyan-500/20">
                        Update Status
                    </button>
                </form>
                <?php endif; ?>
            </div>

            <div class="p-8">
                <!-- Customer Info -->
                <div class="mb-10 bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-500"></i> Informasi Pelanggan
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Tgl Pesanan Dibuat</p>
                            <p class="text-sm font-semibold text-gray-800"><?= date('d F Y - H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Alamat Pengiriman</p>
                            <p class="text-sm font-medium text-gray-700 leading-relaxed"><?= htmlspecialchars($confirm['alamat'] ?? 'Alamat belum diatur (Pesanan tertunda)') ?></p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-utensils text-primary"></i> Menu yang Dipesan
                    </h3>
                    
                    <?php if(!empty($details)): ?>
                    <div class="space-y-4">
                        <?php foreach($details as $item): 
                            $itemTotal = $item['price'] * $item['qty'];
                            $totalPrice += $itemTotal;
                        ?>
                        <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 bg-white hover:border-primary/30 transition shadow-sm group">
                            <img src="<?= BASEURL ?>/uploads/foods/<?= htmlspecialchars($item['image_name']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-20 h-20 object-cover rounded-lg shadow-sm" onerror="this.src='https://via.placeholder.com/150?text=No+Image'">
                            <div class="flex-grow">
                                <h4 class="font-bold text-gray-800 group-hover:text-primary transition"><?= htmlspecialchars($item['title']) ?></h4>
                                <div class="flex justify-between items-end mt-2">
                                    <p class="text-sm text-gray-500 font-medium">Rp <?= number_format($item['price'], 0, ',', '.') ?> <span class="text-gray-400">×</span> <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-700"><?= htmlspecialchars($item['qty']) ?></span></p>
                                    <p class="font-extrabold text-gray-900 text-lg">Rp <?= number_format($itemTotal, 0, ',', '.') ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-100">
                        <i class="fas fa-box-open text-3xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500 font-medium">Detail pesanan tidak ditemukan.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Summary -->
            <?php if(!empty($details)): ?>
            <div class="bg-gray-50 p-8 border-t border-gray-100">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-medium text-gray-600">Subtotal</span>
                    <span class="font-bold text-gray-800">Rp <?= number_format($totalPrice, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <span class="font-medium text-gray-600">Pengiriman</span>
                    <span class="font-bold text-gray-800">Rp 15.000</span>
                </div>
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <span class="text-xl font-bold text-gray-900">Total Keseluruhan</span>
                    <span class="text-3xl font-extrabold text-primary">Rp <?= number_format(($totalPrice) + 15000, 0, ',', '.') ?></span>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Payment Proof Section -->
            <?php if(isset($confirm) && !empty($confirm['image_name'])): ?>
            <div class="bg-indigo-50 p-8 border-t border-indigo-100">
                <h3 class="text-xl font-bold text-indigo-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-indigo-600"></i> Bukti Pembayaran
                </h3>
                <div class="flex flex-col sm:flex-row gap-8 items-start">
                    <div class="w-full sm:w-1/2 bg-white p-2 rounded-2xl border border-indigo-200 shadow-sm">
                        <!-- Make the image clickable to view larger -->
                        <a href="<?= BASEURL ?>/images/confirm/<?= htmlspecialchars($confirm['image_name']) ?>" target="_blank" title="Klik untuk memperbesar">
                            <img src="<?= BASEURL ?>/images/confirm/<?= htmlspecialchars($confirm['image_name']) ?>" alt="Bukti Pembayaran" class="w-full h-auto rounded-xl max-h-96 object-contain bg-gray-50 cursor-zoom-in hover:opacity-90 transition" onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan'">
                        </a>
                    </div>
                    <div class="w-full sm:w-1/2 space-y-4">
                        <div>
                            <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                            <p class="text-base font-semibold text-indigo-900"><?= htmlspecialchars($confirm['payment'] ?? 'Transfer Bank') ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">Atas Nama Rekening</p>
                            <p class="text-base font-semibold text-indigo-900"><?= htmlspecialchars($confirm['rekening_name'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">Tanggal Upload Bukti</p>
                            <p class="text-base font-semibold text-indigo-900">
                                <?= !empty($confirm['tgl_pay']) && $confirm['tgl_pay'] !== '0000-00-00' ? date('d F Y', strtotime($confirm['tgl_pay'])) : '-' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="bg-red-50 p-6 border-t border-red-100 flex items-center gap-4 text-red-700">
                <i class="fas fa-exclamation-circle text-2xl"></i>
                <div>
                    <h4 class="font-bold sm:mb-1">Belum Ada Bukti Pembayaran</h4>
                    <p class="text-sm">Pelanggan belum mengunggah bukti pembayaran untuk pesanan ini.</p>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>
