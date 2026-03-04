<?php 
$title = "Kelola Pelanggan Perusahaan";
ob_start();
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-users text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Pelanggan Terdaftar
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Lacak identitas dan riwayat pelanggan terafiliasi</p>
    </div>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'Identitas Pelanggan', 'class' => ''],
    ['text' => 'Alamat Elektronik', 'class' => ''],
    ['text' => 'Metrik Pesanan', 'class' => 'text-center'],
    ['text' => 'Jejak Waktu', 'class' => ''],
    ['text' => 'Aksi', 'class' => 'text-right min-w-[140px]']
];
$is_empty = empty($users);

ob_start();
if(!$is_empty): $sn=1; foreach($users as $client): ?>
    <tr class="group">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td class="font-bold text-slate-800 align-middle">
            <div class="flex items-center gap-3 group-hover:text-indigo-600 transition-colors">
                <img src="<?= BASEURL ?>/uploads/users/<?= htmlspecialchars($client['img_user'] ?? 'default.jpg') ?>" class="w-10 h-10 rounded-full ring-2 ring-white shadow-sm shrink-0" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($client['username']) ?>&background=random&color=fff'">
                <span><?= htmlspecialchars($client['username']) ?></span>
            </div>
        </td>
        <td class="text-[13px] text-slate-500 font-mono font-medium"><?= htmlspecialchars($client['email']) ?></td>
        <td class="text-center">
            <?php 
                $orderCount = (int)($client['total_orders'] ?? 0);
                $text = $orderCount . ' Pesanan';
                $color = $orderCount > 0 ? 'indigo' : 'gray';
                $icon = false;
                include __DIR__ . '/../components/admin/ui/badge.php';
            ?>
        </td>
        <td class="text-[11px] text-slate-400 font-bold uppercase tracking-wide whitespace-nowrap">
            <div class="mb-1.5 flex items-center text-slate-500"><i class="fas fa-arrow-turn-up text-emerald-500/70 mr-1.5 w-3 text-center"></i> <?= strtoupper(date('d M y H:i', strtotime($client['created_at']))) ?></div>
            <div class="flex items-center"><i class="fas fa-pen text-indigo-400/70 mr-1.5 w-3 text-center"></i> <?= strtoupper(date('d M y H:i', strtotime($client['updated_at'] ?? $client['created_at']))) ?></div>
        </td>
        <td class="text-right">
            <div class="flex flex-col gap-2 w-full max-w-[140px] ml-auto">
                <?php
                    $href = BASEURL . '/admin/clientDetails/' . urlencode($client['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
                <form action="<?= BASEURL ?>/admin/deleteClient/<?= urlencode($client['id']) ?>" method="POST" class="delete-form m-0 w-full" data-name="pelanggan <?= htmlspecialchars($client['username']) ?>">
                <?= CSRF::getTokenField() ?>
                <?php
                    $type = 'submit';
                    $color = 'red';
                    $icon = 'fas fa-trash-alt';
                    $btn_title = 'Revoke Pelanggan';
                    $btn_label = 'Revoke';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
            </form>
            </div>
        </td>
    </tr>
<?php endforeach; endif;

$tableSlot = ob_get_clean();

$slot = $tableSlot;
$empty_icon = 'fas fa-users';
$empty_title = 'Belum Ada Pelanggan';
$empty_message = 'Tidak ada pelanggan terdaftar ditemukan di basis data perusahaan.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>

