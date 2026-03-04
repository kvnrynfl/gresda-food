<?php 
$title = "Kelola Testimoni Pelanggan";
ob_start();
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-star text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Testimoni Pelanggan
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Bermitra dengan bukti interaksi pelanggan positif</p>
    </div>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'Ref Transisi', 'class' => ''],
    ['text' => 'Tingkat Metrik', 'class' => ''],
    ['text' => 'Teks Testimoni', 'class' => ''],
    ['text' => 'Jejak Waktu', 'class' => ''],
    ['text' => 'Status Berita', 'class' => 'w-32 text-center'],
    ['text' => 'Resolusi', 'class' => 'w-48 text-right']
];
$is_empty = empty($reviews);

ob_start();
if(!$is_empty): $sn=1; foreach($reviews as $review): ?>
    <tr class="group">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td>
            <div class="font-extrabold text-[15px] text-slate-800 line-clamp-1 mb-1 tracking-tight">
                <span class="text-slate-400 font-medium text-[13px] mr-1"></span>#<?= htmlspecialchars($review['order_id'] ?? 'N/A') ?>
            </div>
            <div class="text-[13px] text-indigo-500 font-bold flex items-center gap-1.5">
                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($review['username'] ?? 'User #'.$review['user_id']) ?>
            </div>
        </td>
        <td>
            <div class="flex text-amber-500 gap-0.5">
                <?php 
                    $rating = floor($review['rating'] ?? 0);
                    for($i = 0; $i < 5; $i++) {
                        if($i < $rating) echo '<i class="fas fa-star text-[14px]"></i>';
                        else echo '<i class="far fa-star text-[14px] text-slate-300"></i>';
                    }
                ?>
            </div>
        </td>
        <td class="text-[13px] text-slate-600 font-medium leading-relaxed max-w-xs xl:max-w-sm">
            <div class="line-clamp-2">
                <?= nl2br(htmlspecialchars($review['message'] ?? '')) ?>
            </div>
        </td>
        <td class="text-[11px] text-slate-400 font-bold uppercase tracking-wide whitespace-nowrap">
            <div class="mb-1.5 flex items-center text-slate-500"><i class="fas fa-arrow-turn-up text-emerald-500/70 mr-1.5 w-3 text-center"></i> <?= strtoupper(date('d M y H:i', strtotime($review['created_at']))) ?></div>
            <div class="flex items-center"><i class="fas fa-pen text-indigo-400/70 mr-1.5 w-3 text-center"></i> <?= strtoupper(date('d M y H:i', strtotime($review['updated_at'] ?? $review['created_at']))) ?></div>
        </td>
        <td class="text-center">
            <?php 
                $reviewStatus = $review['status'] ?? 'pending';
                if ($reviewStatus === 'approved') {
                    $text = 'Dipublikasi';
                    $color = 'green';
                    $icon = 'fas fa-check-circle';
                } elseif ($reviewStatus === 'rejected') {
                    $text = 'Ditolak';
                    $color = 'red';
                    $icon = 'fas fa-times-circle';
                } else {
                    $text = 'Menunggu';
                    $color = 'orange';
                    $icon = 'fas fa-clock';
                }
                include __DIR__ . '/../components/admin/ui/badge.php';
            ?>
        </td>
        <td class="text-right">
            <div class="flex flex-col gap-2 w-full max-w-[140px] ml-auto">
                <?php
                    $type = 'a';
                    $href = BASEURL . '/admin/reviewDetails/' . urlencode($review['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
                
                <?php if ($review['status'] !== 'approved'): ?>
                    <form action="<?= BASEURL ?>/admin/updateTestimonialStatus/<?= urlencode($review['id']) ?>" method="POST" class="m-0 w-full">
                        <?= CSRF::getTokenField() ?>
                        <input type="hidden" name="status" value="approved">
                        <?php
                            $type = 'submit';
                            $color = 'green';
                            $icon = 'fas fa-check';
                            $btn_title = 'Tampilkan';
                            $btn_label = 'Tampilkan';
                            $btn_width = 'w-full';
                            include __DIR__ . '/../components/admin/ui/action_button.php';
                        ?>
                    </form>
                <?php endif; ?>
                
                <?php if ($review['status'] === 'approved'): ?>
                    <form action="<?= BASEURL ?>/admin/updateTestimonialStatus/<?= urlencode($review['id']) ?>" method="POST" class="m-0 w-full">
                        <?= CSRF::getTokenField() ?>
                        <input type="hidden" name="status" value="rejected">
                        <?php
                            $type = 'submit';
                            $color = 'gray';
                            $icon = 'fas fa-eye-slash';
                            $btn_title = 'Sembunyikan';
                            $btn_label = 'Sembunyi';
                            $btn_width = 'w-full';
                            include __DIR__ . '/../components/admin/ui/action_button.php';
                        ?>
                    </form>
                <?php endif; ?>

                <form action="<?= BASEURL ?>/admin/deleteTestimonial/<?= urlencode($review['id']) ?>" method="POST" class="delete-form m-0 w-full" data-name="Testimoni ini">
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
$empty_icon = 'far fa-comment-dots';
$empty_title = 'Tidak Ada Testimoni';
$empty_message = 'Pelanggan belum mengirimkan testimoni proyek apa pun.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>

