<?php 
$title = "Kelola Daftar Menu";
ob_start();
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-burger text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Daftar Menu
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Katalog makanan dan layanan untuk pelanggan</p>
    </div>
    <a href="<?= BASEURL ?>/admin/createFood" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[14px] shadow-[0_4px_14px_0_rgba(79,70,229,0.39)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.23)] hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2.5 text-[14px] font-extrabold whitespace-nowrap focus:outline-none focus:ring-4 focus:ring-indigo-500/20">
        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Menu Eksperimen</span>
    </a>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'Item Makanan', 'class' => ''],
    ['text' => 'Harga Jual', 'class' => ''],
    ['text' => 'Kategori Menu', 'class' => ''],
    ['text' => 'Siklus Dibuat', 'class' => ''],
    ['text' => 'Status Menu', 'class' => ''],
    ['text' => 'Opsi Aksi', 'class' => 'text-right min-w-[140px]']
];
$is_empty = empty($foods);

ob_start();
if(!$is_empty): $sn=1; foreach($foods as $product): ?>
    <tr class="group">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td>
            <div class="flex items-center gap-4">
                <div class="w-[52px] h-[52px] rounded-[14px] bg-slate-100 overflow-hidden flex-shrink-0 ring-1 ring-slate-200 group-hover:ring-indigo-200 transition-all shadow-sm">
                    <img src="<?= BASEURL ?>/uploads/food/<?= htmlspecialchars($product['image']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($product['name'] ?? 'Product') ?>&background=random&color=fff'">
                </div>
                <div>
                    <div class="font-black text-slate-800 text-[15px] leading-tight mb-1 group-hover:text-indigo-600 transition-colors"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="text-[12px] text-slate-500 font-medium line-clamp-1 w-48 opacity-80"><?= htmlspecialchars($product['description']) ?></div>
                </div>
            </div>
        </td>
        <td class="font-extrabold text-slate-700 text-[14px]">Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?></td>
        <td>
            <?php 
                $text = htmlspecialchars($product['category_name'] ?? 'Tidak ada');
                $color = 'indigo';
                $icon = 'fas fa-tag';
                include __DIR__ . '/../components/admin/ui/badge.php';
            ?>
        </td>
        <td class="text-[11px] text-slate-400 font-bold uppercase tracking-wide whitespace-nowrap">
            <div class="mb-1.5 flex items-center text-slate-500"><i class="fas fa-arrow-turn-up text-emerald-500/70 mr-1.5 w-3 text-center"></i> <?= date('d M y H:i', strtotime($product['created_at'])) ?></div>
            <div class="flex items-center"><i class="fas fa-pen text-indigo-400/70 mr-1.5 w-3 text-center"></i> <?= date('d M y H:i', strtotime($product['updated_at'])) ?></div>
        </td>
        <td>
            <?php 
                $isActive = !empty($product['is_active']);
                $text = $isActive ? 'Dihidangkan' : 'Diarsipkan';
                $color = $isActive ? 'green' : 'gray';
                $icon = $isActive ? 'fas fa-check-circle' : 'fas fa-box-archive';
                include __DIR__ . '/../components/admin/ui/badge.php';
            ?>
        </td>
        <td class="text-right">
            <div class="flex flex-col gap-2 w-full max-w-[140px] ml-auto">
                <?php
                    $href = BASEURL . '/admin/foodDetails/' . urlencode($product['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';

                    $href = BASEURL . '/admin/editFood/' . urlencode($product['id']);
                    $color = 'blue';
                    $icon = 'fas fa-edit';
                    $btn_title = 'Edit';
                    $btn_label = 'Edit';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
                <form action="<?= BASEURL ?>/admin/toggleFood/<?= urlencode($product['id']) ?>" method="POST" class="m-0 w-full">
                    <?= CSRF::getTokenField() ?>
                    <?php
                        $type = 'submit';
                        $color = !empty($product['is_active']) ? 'amber' : 'emerald';
                        $icon = !empty($product['is_active']) ? 'fas fa-toggle-off' : 'fas fa-toggle-on';
                        $btn_title = !empty($product['is_active']) ? 'Nonaktifkan' : 'Aktifkan';
                        $btn_label = !empty($product['is_active']) ? 'Nonaktifkan' : 'Aktifkan';
                        $btn_width = 'w-full';
                        include __DIR__ . '/../components/admin/ui/action_button.php';
                    ?>
                </form>
                <form action="<?= BASEURL ?>/admin/deleteFood/<?= urlencode($product['id']) ?>" method="POST" class="w-full delete-form m-0" data-name="<?= htmlspecialchars($product['name']) ?>">
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
$empty_icon = 'fas fa-box-open';
$empty_title = 'Tidak Ada Makanan Ditemukan';
$empty_message = 'Saat ini tidak ada menu yang ditambahkan ke basis data perusahaan.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
