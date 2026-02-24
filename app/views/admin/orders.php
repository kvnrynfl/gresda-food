<?php 
$title = "Kelola Pesanan Aktif";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-gray-50 gap-4">
        <h3 class="text-lg font-bold text-gray-800"><i class="fas fa-boxes mr-2 text-primary"></i> Panel Pelacakan Pesanan</h3>
        <div class="flex gap-2 text-sm font-semibold">
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Pembayaran</span>
            <span class="flex items-center gap-1 ml-3"><span class="w-3 h-3 rounded-full bg-orange-500"></span> Pengiriman</span>
            <span class="flex items-center gap-1 ml-3"><span class="w-3 h-3 rounded-full bg-green-500"></span> Selesai</span>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead>
                <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                    <td class="px-6 py-4 w-16">No.</td>
                    <td class="px-6 py-4">Ref Pesanan</td>
                    <td class="px-6 py-4">Info Pelanggan</td>
                    <td class="px-6 py-4 w-32 text-center">Tgl Dibuat / Tgl Update</td>
                    <td class="px-6 py-4 text-center w-48">Status Saat Ini</td>
                    <td class="px-6 py-4 text-center w-64">Aksi</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($orders)): $sn=1; foreach($orders as $order): ?>
                    <tr class="hover:bg-gray-50 transition group <?= ($order['status'] === 'Finished') ? 'opacity-60 bg-gray-50' : '' ?>">
                        <td class="px-6 py-4 text-sm text-gray-500"><?= $sn++ ?>.</td>
                        <td class="px-6 py-4 font-mono font-bold text-gray-800">#<?= htmlspecialchars($order['order_id']) ?></td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-user-circle text-gray-400"></i>
                                <?= htmlspecialchars($order['username'] ?? 'User #'.$order['user_id']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500 text-center font-mono">
                            <div class="mb-1 text-gray-600" title="Waktu Dibuat"><i class="fas fa-plus-circle text-green-500 mr-1"></i> <?= date('d M y H:i', strtotime($order['created_at'])) ?></div>
                            <div title="Waktu Pembaharuan"><i class="fas fa-edit text-blue-400 mr-1"></i> <?= date('d M y H:i', strtotime($order['updated_at'])) ?></div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php 
                                $statusMap = [
                                    'Cart' => 'Keranjang',
                                    'Payment' => 'Pembayaran',
                                    'Confirmed' => 'Dikonfirmasi',
                                    'Delivery' => 'Pengiriman',
                                    'Finished' => 'Selesai',
                                    'Canceled' => 'Dibatalkan'
                                ];
                                $statusClass = 'bg-gray-100 text-gray-600';
                                $icon = 'fa-clock';
                                switch($order['status']) {
                                    case 'Cart': $statusClass = 'bg-gray-100 text-gray-600'; $icon = 'fa-shopping-cart'; break;
                                    case 'Payment': $statusClass = 'bg-blue-100 text-blue-700'; $icon = 'fa-wallet'; break;
                                    case 'Confirmed': $statusClass = 'bg-indigo-100 text-indigo-700'; $icon = 'fa-check'; break;
                                    case 'Delivery': $statusClass = 'bg-orange-100 text-orange-700'; $icon = 'fa-motorcycle'; break;
                                    case 'Finished': $statusClass = 'bg-green-100 text-green-700'; $icon = 'fa-box-open'; break;
                                    case 'Canceled': $statusClass = 'bg-cyan-100 text-cyan-700'; $icon = 'fa-ban'; break;
                                }
                            ?>
                            <div class="inline-flex items-center gap-1.5 <?= $statusClass ?> px-3 py-1 rounded-full font-bold text-xs ring-1 ring-inset ring-current/20">
                                <i class="fas <?= $icon ?>"></i> <?= htmlspecialchars($statusMap[$order['status']] ?? $order['status']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col gap-2 items-center justify-center">
                                <?php if ($order['status'] !== 'Finished' && $order['status'] !== 'Canceled' && $order['status'] !== 'Cart'): ?>
                                <form action="<?= BASEURL ?>/admin/updateOrderStatus/<?= urlencode($order['order_id']) ?>" method="POST" class="flex gap-1 justify-center w-full">
                                    <?= CSRF::getTokenField() ?>
                                    <select name="status" class="text-xs border border-gray-300 rounded-lg px-2 py-1 outline-none focus:ring-1 focus:ring-primary focus:border-primary w-28">
                                        <option value="Confirmed" <?= ($order['status'] == 'Confirmed') ? 'selected' : '' ?>>Dikonfirmasi</option>
                                        <option value="Delivery" <?= ($order['status'] == 'Delivery') ? 'selected' : '' ?>>Pengiriman</option>
                                        <option value="Finished" <?= ($order['status'] == 'Finished') ? 'selected' : '' ?>>Selesai</option>
                                        <option value="Canceled">Batalkan</option>
                                    </select>
                                    <button type="submit" title="Simpan Status" class="bg-gray-800 text-white text-xs px-2 py-1 rounded-lg hover:bg-black transition font-semibold shadow-sm">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                <a href="<?= BASEURL ?>/admin/orderDetails/<?= urlencode($order['order_id']) ?>" class="bg-white border border-primary text-primary hover:bg-primary hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition shadow-sm w-full text-center">
                                    <i class="fas fa-eye mr-1"></i> Detail Pesanan
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-clipboard-list text-5xl mb-4 text-gray-200"></i>
                            <h3 class="text-xl font-bold text-gray-500 mb-1">Tidak Ada Pesanan Aktif</h3>
                            <p>Pelanggan belum melakukan pesanan apa pun akhir-akhir ini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>


