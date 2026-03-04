<?php 
$title = "Kelola Kategori Menu";
ob_start();
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-folder-tree text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Semua Kategori Menu
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Pengelompokan struktur portofolio makanan</p>
    </div>
    <a href="<?= BASEURL ?>/admin/createCategory" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[14px] shadow-[0_4px_14px_0_rgba(79,70,229,0.39)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.23)] hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2.5 text-[14px] font-extrabold whitespace-nowrap focus:outline-none focus:ring-4 focus:ring-indigo-500/20">
        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Kategori</span>
    </a>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'Nama Tampilan', 'class' => ''],
    ['text' => 'Label Akses (Slug)', 'class' => ''],
    ['text' => 'Jejak Waktu', 'class' => ''],
    ['text' => 'Status Operasional', 'class' => ''],
    ['text' => 'Aksi', 'class' => 'text-right min-w-[140px]']
];
$is_empty = empty($categories);

ob_start();
if(!$is_empty): $sn=1; foreach($categories as $index => $cat): ?>
    <tr class="group">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td class="text-[15px] font-black text-slate-800 group-hover:text-indigo-600 transition-colors"><?= htmlspecialchars($cat['name']) ?></td>
        <td class="text-[13px] text-slate-500 font-mono font-bold"><?= htmlspecialchars($cat['slug']) ?></td>
        <td class="text-[11px] text-slate-400 font-bold uppercase tracking-wide whitespace-nowrap">
            <div class="mb-1.5 flex items-center text-slate-500"><i class="fas fa-arrow-turn-up text-emerald-500/70 mr-1.5 w-3 text-center"></i> <?= date('d M y H:i', strtotime($cat['created_at'])) ?></div>
            <div class="flex items-center"><i class="fas fa-pen text-indigo-400/70 mr-1.5 w-3 text-center"></i> <?= date('d M y H:i', strtotime($cat['updated_at'])) ?></div>
        </td>
        <td>
            <?php 
                $isActive = !empty($cat['is_active']);
                $text = $isActive ? 'Diterapkan' : 'Dibekukan';
                $color = $isActive ? 'green' : 'gray';
                $icon = $isActive ? 'fas fa-check-circle' : 'fas fa-box-archive';
                include __DIR__ . '/../components/admin/ui/badge.php';
            ?>
        </td>
        <td class="text-right">
            <div class="flex flex-col gap-2 w-full max-w-[140px] ml-auto">
                <?php
                    $type = 'a';
                    $href = BASEURL . '/admin/categoryDetails/' . urlencode($cat['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';

                    $href = BASEURL . '/admin/editCategory/' . urlencode($cat['id']);
                    $color = 'blue';
                    $icon = 'fas fa-edit';
                    $btn_title = 'Edit';
                    $btn_label = 'Edit';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
                <form action="<?= BASEURL ?>/admin/toggleCategory/<?= urlencode($cat['id']) ?>" method="POST" class="m-0 w-full">
                    <?= CSRF::getTokenField() ?>
                    <?php
                        $type = 'submit';
                        $color = !empty($cat['is_active']) ? 'amber' : 'emerald';
                        $icon = !empty($cat['is_active']) ? 'fas fa-toggle-off' : 'fas fa-toggle-on';
                        $btn_title = !empty($cat['is_active']) ? 'Nonaktifkan' : 'Aktifkan';
                        $btn_label = !empty($cat['is_active']) ? 'Nonaktifkan' : 'Aktifkan';
                        $btn_width = 'w-full';
                        include __DIR__ . '/../components/admin/ui/action_button.php';
                    ?>
                </form>
                <form action="<?= BASEURL ?>/admin/deleteCategory/<?= urlencode($cat['id']) ?>" method="POST" class="delete-form m-0 w-full" data-name="Kategori <?= htmlspecialchars($cat['name']) ?>">
                    <?= CSRF::getTokenField() ?>
                    <?php
                        $type = 'submit';
                        $color = 'red';
                        $icon = 'fas fa-trash-alt';
                        $btn_title = 'Hapus';
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
$empty_icon = 'fas fa-tags';
$empty_title = 'Belum Ada Kategori';
$empty_message = 'Tidak ada kategori yang ditemukan dalam basis data.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>

