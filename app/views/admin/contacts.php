<?php 
$title = "Kelola Pesan Pelanggan";
ob_start();
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-envelope text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Kotak Keluhan & Pesan
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Layanan umpan balik dan keluhan pelanggan masuk</p>
    </div>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'Identitas Pengirim', 'class' => ''],
    ['text' => 'Substansi Pesan', 'class' => ''],
    ['text' => 'Jejak Waktu', 'class' => ''],
    ['text' => 'Tindakan', 'class' => 'w-[140px] text-right']
];
$is_empty = empty($contacts);

ob_start();
if(!$is_empty): $sn=1; foreach($contacts as $contact): ?>
    <tr class="group">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td>
            <div class="font-extrabold text-[15px] text-slate-800 tracking-tight"><?= htmlspecialchars($contact['name']) ?></div>
            <div class="text-[13px] text-indigo-500 font-mono font-bold"><?= htmlspecialchars($contact['email']) ?></div>
        </td>
        <td class="text-[13px] text-slate-600 font-medium leading-relaxed max-w-xs xl:max-w-md">
            <div class="line-clamp-2">
                <?= nl2br(htmlspecialchars($contact['message'])) ?>
            </div>
        </td>
        <td class="text-[11px] text-slate-400 font-bold uppercase tracking-wide whitespace-nowrap">
            <div class="flex items-center text-slate-500"><i class="fas fa-arrow-turn-up text-emerald-500/70 mr-1.5 w-3 text-center"></i> <?= strtoupper(date('d M y H:i', strtotime($contact['created_at']))) ?></div>
        </td>
        <td class="text-right">
            <div class="flex flex-col gap-2 w-full max-w-[140px] ml-auto">
                <?php
                    $type = 'a';
                    $href = BASEURL . '/admin/contactDetails/' . urlencode($contact['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
                <form action="<?= BASEURL ?>/admin/deleteContact/<?= urlencode($contact['id']) ?>" method="POST" class="delete-form m-0 w-full" data-name="Pesan ini">
                    <?= CSRF::getTokenField() ?>
                    <?php
                        $type = 'submit';
                        $color = 'red';
                        $icon = 'fas fa-trash-alt';
                        $btn_title = 'Hapus Pesan';
                        $btn_label = 'Hapus';
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
$empty_icon = 'fas fa-envelope-open';
$empty_title = 'Kotak Surat Kosong';
$empty_message = 'Belum ada umpan balik pelanggan di log saat ini.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>

