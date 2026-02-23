<?php 
$title = "Kelola Ulasan Pelanggan";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800"><i class="fas fa-star mr-2 text-yellow-500"></i> Umpan Balik Pelanggan</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                    <td class="px-6 py-4 w-16">ID</td>
                    <td class="px-6 py-4">Makanan / Pelanggan</td>
                    <td class="px-6 py-4">Penilaian</td>
                    <td class="px-6 py-4">Teks Ulasan</td>
                    <td class="px-6 py-4 w-32 text-center">Status</td>
                    <td class="px-6 py-4 w-28 text-center">Aksi</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($reviews)): foreach($reviews as $review): ?>
                    <tr class="hover:bg-blue-50 transition group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono">#<?= $review['id'] ?></td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800 line-clamp-1">Pesanan #<?= htmlspecialchars($review['order_id'] ?? 'Tidak Diketahui') ?></div>
                            <div class="text-xs text-gray-500">Oleh pengguna #<?= htmlspecialchars($review['user_id']) ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex text-yellow-400">
                                <?php 
                                    $rating = floor($review['rating'] ?? 0);
                                    for($i = 0; $i < 5; $i++) {
                                        if($i < $rating) echo '<i class="fas fa-star text-sm"></i>';
                                        else echo '<i class="far fa-star text-sm"></i>';
                                    }
                                ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 line-clamp-2 md:line-clamp-3 w-64">
                            <?= nl2br(htmlspecialchars($review['message'] ?? '')) ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if (($review['active'] ?? '') === 'Yes'): ?>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-xs">Publik</span>
                            <?php else: ?>
                                <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full font-bold text-xs">Sembunyi</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="<?= BASEURL ?>/admin/deleteReview/<?= $review['id'] ?>" method="POST" onsubmit="return confirm('Hapus ulasan ini sepenuhnya?');">
                                <button type="submit" class="w-8 h-8 rounded-full bg-cyan-100 text-cyan-600 inline-flex items-center justify-center hover:bg-cyan-600 hover:text-white transition shadow-sm" title="Hapus Ulasan">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <i class="far fa-comment-dots text-5xl mb-4 text-gray-200"></i>
                            <h3 class="text-xl font-bold text-gray-500 mb-1">Tidak Ada Ulasan</h3>
                            <p>Pelanggan belum mengirimkan umpan balik apa pun.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>

