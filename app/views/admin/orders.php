<?php 
$title = "Kelola Pesanan Aktif";
ob_start();

$statusLabels = [
    'pending_payment' => 'Menunggu Bayar',
    'confirmed' => 'Dikonfirmasi',
    'processing' => 'Diproses',
    'delivering' => 'Dikirim',
    'finished' => 'Selesai',
    'cancelled' => 'Dibatalkan'
];
$statusColors = [
    'pending_payment' => 'blue',
    'confirmed' => 'indigo',
    'processing' => 'violet',
    'delivering' => 'orange',
    'finished' => 'green',
    'cancelled' => 'red'
];
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-boxes text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Panel Pelacakan Pesanan
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Pantau dan kelola semua pesanan pelanggan yang sedang aktif dalam siklus waktu nyata.</p>
    </div>
    
    <div class="flex flex-wrap gap-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest bg-white px-5 py-3 rounded-xl border border-slate-200/80 hover:shadow-[0_4px_24px_rgba(0,0,0,0.03)] transition-all">
        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-sm shadow-blue-500/50"></span> Menunggu Bayar</span>
        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shadow-sm shadow-indigo-500/50"></span> Dikonfirmasi</span>
        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-orange-500 shadow-sm shadow-orange-500/50"></span> Dikirim</span>
        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span> Selesai</span>
    </div>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'No. Pesanan & Pelanggan', 'class' => ''],
    ['text' => 'Total', 'class' => 'text-right'],
    ['text' => 'Status', 'class' => 'text-center w-40'],
    ['text' => 'Aksi', 'class' => 'text-right min-w-[200px]']
];
$is_empty = empty($orders);

ob_start();
if(!$is_empty): $sn=1; foreach($orders as $transaction): ?>
    <tr x-data="{ showStatusModal: false }" class="group transition-colors <?= ($transaction['status'] === 'finished') ? 'opacity-60 bg-slate-50/50' : '' ?>">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td>
            <div class="font-extrabold text-[15px] text-slate-800 line-clamp-1 mb-1 tracking-tight">
                <?= htmlspecialchars($transaction['order_number'] ?? substr($transaction['id'], 0, 8)) ?>
            </div>
            <div class="text-[13px] text-indigo-500 font-bold flex items-center gap-1.5">
                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($transaction['customer_name'] ?? $transaction['username'] ?? 'N/A') ?>
            </div>
            <div class="text-[11px] text-slate-400 font-mono mt-1">
                <i class="fas fa-calendar-day mr-1 opacity-50"></i><?= date('d M y H:i', strtotime($transaction['created_at'])) ?>
            </div>
        </td>
        <td class="text-right text-[15px] font-black text-slate-800">
            Rp <?= number_format($transaction['grand_total'] ?? 0, 0, ',', '.') ?>
        </td>
        <td class="text-center">
            <?php 
                $text = $statusLabels[$transaction['status']] ?? $transaction['status'];
                $color = $statusColors[$transaction['status']] ?? 'gray';
                $icon = false;
                include __DIR__ . '/../components/admin/ui/badge.php';
            ?>
        </td>
        <td class="text-right">
            <div class="flex items-center justify-end gap-2.5 w-full">
                <?php
                    $type = 'a';
                    $href = BASEURL . '/admin/orderDetails/' . urlencode($transaction['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $extra_attr = '';
                    include __DIR__ . '/../components/admin/ui/action_button.php';

                    if (!in_array($transaction['status'], ['finished', 'cancelled'])):
                    $type = 'button';
                    $color = 'amber';
                    $icon = 'fas fa-sync-alt';
                    $btn_title = 'Ubah Status Pesanan';
                    $btn_label = 'Status';
                    $extra_attr = '@click="showStatusModal = true"';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                    endif;
                ?>
            </div>

            <!-- Modal Background -->
            <div x-show="showStatusModal" style="display: none;" class="fixed inset-0 z-[99] bg-slate-900/40 backdrop-blur-sm transition-opacity text-left" x-transition.opacity></div>

            <!-- Modal Panel -->
            <div x-show="showStatusModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 text-left" x-transition.opacity>
                <div @click.outside="showStatusModal = false" class="bg-white rounded-[24px] shadow-2xl w-full max-w-md overflow-hidden transform transition-all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-lg font-black text-slate-800">Ubah Status Pesanan</h3>
                        <button type="button" @click="showStatusModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                    <form action="<?= BASEURL ?>/admin/updateOrderStatus/<?= urlencode($transaction['id']) ?>" method="POST" class="p-6">
                        <?= CSRF::getTokenField() ?>
                        <div class="mb-5">
                            <p class="text-[13px] text-slate-500 mb-3">Tentukan status terbaru untuk pesanan <strong class="text-slate-700 font-extrabold"><?= htmlspecialchars($transaction['order_number'] ?? '') ?></strong>:</p>
                            <div class="relative">
                                <select name="status" class="w-full text-[14px] font-bold text-slate-700 border border-slate-200 bg-white rounded-xl px-4 py-3.5 outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                    <option value="confirmed" <?= ($transaction['status'] == 'confirmed') ? 'selected' : '' ?>>Dikonfirmasi (Pembayaran Diterima)</option>
                                    <option value="processing" <?= ($transaction['status'] == 'processing') ? 'selected' : '' ?>>Sedang Diproses</option>
                                    <option value="delivering" <?= ($transaction['status'] == 'delivering') ? 'selected' : '' ?>>Dalam Pengiriman</option>
                                    <option value="finished" <?= ($transaction['status'] == 'finished') ? 'selected' : '' ?>>Selesai</option>
                                    <option value="cancelled">Batalkan Pesanan</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[12px] pointer-events-none"></i>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end mt-8">
                            <button type="button" @click="showStatusModal = false" class="px-5 py-2.5 rounded-xl text-[13px] font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-[13px] font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-[0_4px_14px_0_rgba(79,70,229,0.39)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.23)] transition-all">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </td>
    </tr>
<?php endforeach; endif;

$tableSlot = ob_get_clean();

$slot = $tableSlot;
$empty_icon = 'fas fa-clipboard-list';
$empty_title = 'Tidak Ada Pesanan Aktif';
$empty_message = 'Pelanggan belum melakukan pesanan apa pun akhir-akhir ini.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
