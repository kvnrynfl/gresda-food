<?php 
$title = "Kelola Kontak";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800"><i class="fas fa-envelope mr-2 text-primary"></i> Pesan Kontak</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                    <td class="px-6 py-4 w-16">ID</td>
                    <td class="px-6 py-4">Pengirim</td>
                    <td class="px-6 py-4">Isi Pesan</td>
                    <td class="px-6 py-4 w-32 text-center">Aksi</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($contacts)): foreach($contacts as $contact): ?>
                    <tr class="hover:bg-blue-50 transition group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono">#<?= $contact['id'] ?></td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800"><?= htmlspecialchars($contact['customer_name']) ?></div>
                            <div class="text-sm text-primary"><?= htmlspecialchars($contact['customer_email']) ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 line-clamp-2 md:line-clamp-3">
                            <?= nl2br(htmlspecialchars($contact['customer_message'])) ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="<?= BASEURL ?>/admin/deleteContact/<?= $contact['id'] ?>" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                                <button type="submit" class="w-8 h-8 rounded-full bg-cyan-100 text-cyan-600 inline-flex items-center justify-center hover:bg-cyan-600 hover:text-white transition shadow-sm" title="Hapus Pesan">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-gray-400">
                            <i class="fas fa-envelope-open text-5xl mb-4 text-gray-200"></i>
                            <h3 class="text-xl font-bold text-gray-500 mb-1">Kotak Masuk Kosong</h3>
                            <p>Tidak ada pesan kontak saat ini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>

