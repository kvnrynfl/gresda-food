<?php 
$title = "Kelola Admin Internal";
ob_start();
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-user-shield text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Personel Admin
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Kelola hak akses administratif pada platform ini</p>
    </div>
    <a href="<?= BASEURL ?>/admin/createAdmin" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[14px] shadow-[0_4px_14px_0_rgba(79,70,229,0.39)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.23)] hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2.5 text-[14px] font-extrabold whitespace-nowrap focus:outline-none focus:ring-4 focus:ring-indigo-500/20">
        <i class="fas fa-user-tie"></i> <span class="hidden sm:inline">Tambah Kredensial</span>
    </a>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'Entitas Personel', 'class' => ''],
    ['text' => 'Alias Akses', 'class' => ''],
    ['text' => 'Waktu Aktivasi', 'class' => ''],
    ['text' => 'Aksi', 'class' => 'text-right min-w-[200px]']
];
$is_empty = empty($admins);

ob_start();
if(!$is_empty): $sn=1; foreach($admins as $adminf): ?>
    <tr class="group">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td class="font-extrabold text-[15px] text-slate-800 align-middle">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-indigo-500 ring-2 ring-white shadow-sm shrink-0">
                    <i class="fas fa-user-shield text-[14px]"></i>
                </div>
                <span><?= htmlspecialchars($adminf['full_name']) ?></span>
                <?php if($adminf['id'] == $_SESSION['user_id']): ?>
                    <?php 
                        $text = 'Otoritas Anda';
                        $color = 'emerald';
                        $icon = false;
                        include __DIR__ . '/../components/admin/ui/badge.php';
                    ?>
                <?php endif; ?>
            </div>
        </td>
        <td class="text-[13px] text-slate-500 font-mono font-bold">@<?= htmlspecialchars($adminf['username']) ?></td>
        <td class="text-[11px] text-slate-400 font-bold uppercase tracking-wide whitespace-nowrap">
            <div class="flex items-center text-slate-500"><i class="fas fa-arrow-turn-up text-emerald-500/70 mr-1.5 w-3 text-center"></i> <?= date('d M Y, H:i', strtotime($adminf['created_at'])) ?></div>
        </td>
        <td class="text-right">
            <div class="flex flex-col gap-2 w-full max-w-[140px] ml-auto">
                <?php
                    $type = 'a';
                    $href = BASEURL . '/admin/adminDetails/' . urlencode($adminf['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';

                    $href = BASEURL . '/admin/editAdmin/' . urlencode($adminf['id']);
                    $color = 'blue';
                    $icon = 'fas fa-edit';
                    $btn_title = 'Edit Profil';
                    $btn_label = 'Edit';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';

                    $href = BASEURL . '/admin/editAdminPassword/' . urlencode($adminf['id']);
                    $color = 'orange';
                    $icon = 'fas fa-key';
                    $btn_title = 'Ubah Kata Sandi';
                    $btn_label = 'Sandi';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
                <?php if($adminf['id'] != $_SESSION['user_id']): ?>
                <form action="<?= BASEURL ?>/admin/deleteAdmin/<?= urlencode($adminf['id']) ?>" method="POST" class="delete-form m-0 w-full" data-name="Admin <?= htmlspecialchars($adminf['username']) ?>">
                    <?= CSRF::getTokenField() ?>
                    <?php
                        $type = 'submit';
                        $color = 'red';
                        $icon = 'fas fa-user-xmark';
                        $btn_title = 'Depresi Admin';
                        $btn_label = 'Hapus';
                        $btn_width = 'w-full';
                        include __DIR__ . '/../components/admin/ui/action_button.php';
                    ?>
                </form>
                <?php endif; ?>
            </div>
        </td>
    </tr>
<?php endforeach; endif;

$tableSlot = ob_get_clean();

$slot = $tableSlot;
$empty_icon = 'fas fa-user-tie';
$empty_title = 'Belum Ada Admin';
$empty_message = 'Tidak ada personel admin internal yang ditemukan.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>

