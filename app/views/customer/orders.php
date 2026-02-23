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

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                            <th class="px-6 py-4">ID Pesanan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if(!empty($orders)): foreach($orders as $order): ?>
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="px-6 py-4 font-mono font-bold text-gray-800">#<?= htmlspecialchars($order['order_id']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar-alt text-gray-400"></i>
                                        <?= date('d M Y', strtotime($order['tgl_order'] ?? 'now')) ?>
                                    </div>
                                </td>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800">
                                    Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php 
                                        $statusClass = 'bg-gray-100 text-gray-600';
                                        $statusMap = [
                                            'Cart' => 'Keranjang',
                                            'Payment' => 'Pembayaran',
                                            'Confirmed' => 'Dikonfirmasi',
                                            'Delivery' => 'Dikirim',
                                            'Finished' => 'Selesai',
                                            'Canceled' => 'Dibatalkan'
                                        ];
                                        switch($order['status']) {
                                            case 'Cart': $statusClass = 'bg-gray-100 text-gray-600'; break;
                                            case 'Payment': $statusClass = 'bg-blue-100 text-blue-700'; break;
                                            case 'Confirmed': $statusClass = 'bg-indigo-100 text-indigo-700'; break;
                                            case 'Delivery': $statusClass = 'bg-orange-100 text-orange-700'; break;
                                            case 'Finished': $statusClass = 'bg-green-100 text-green-700'; break;
                                            case 'Canceled': $statusClass = 'bg-cyan-100 text-cyan-700'; break;
                                        }
                                        $statusText = $statusMap[$order['status']] ?? $order['status'];
                                    ?>
                                    <span class="inline-flex items-center <?= $statusClass ?> px-3 py-1 rounded-full font-bold text-xs">
                                        <?= htmlspecialchars($statusText) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?= BASEURL ?>/customer/orderDetails/<?= urlencode($order['order_id']) ?>" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-bold shadow-sm transition">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-400">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                        <i class="fas fa-shopping-bag text-3xl text-gray-300"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-600 mb-1">Belum Ada Pesanan</h3>
                                    <p class="text-sm">Anda belum melakukan pesanan apa pun. Mulai jelajahi menu kami!</p>
                                    <a href="<?= BASEURL ?>/menu" class="mt-4 inline-block px-6 py-2 bg-cyan-600 text-white rounded-lg font-bold shadow-sm hover:bg-cyan-700 transition">Telusuri Menu</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>


