<?php 
$title = "Kelola Kategori";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Semua Kategori</h3>
        <a href="<?= BASEURL ?>/admin/createCategory" class="px-4 py-2 bg-cyan-600 text-white rounded shadow-sm hover:bg-cyan-700 transition flex items-center gap-2 text-sm font-bold">
            <i class="fas fa-plus"></i> Tambah Kategori Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider font-semibold border-b border-gray-200">
                    <td class="px-6 py-4">ID</td>
                    <td class="px-6 py-4">Nama Tampilan</td>
                    <td class="px-6 py-4">Slug</td>
                    <td class="px-6 py-4">Status</td>
                    <td class="px-6 py-4 text-center">Aksi</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($categories)): foreach($categories as $index => $cat): ?>
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-6 py-4 text-sm text-gray-500">#<?= $cat['id'] ?></td>
                        <td class="px-6 py-4 font-bold text-gray-800"><?= htmlspecialchars($cat['name']) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono"><?= htmlspecialchars($cat['category']) ?></td>
                        <td class="px-6 py-4 text-sm">
                            <?php if ($cat['active'] === 'Yes'): ?>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-xs"><i class="fas fa-check-circle mr-1"></i> Aktif</span>
                            <?php else: ?>
                                <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full font-bold text-xs"><i class="fas fa-times-circle mr-1"></i> Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="<?= BASEURL ?>/admin/editCategory/<?= $cat['id'] ?>" class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="<?= BASEURL ?>/admin/deleteCategory/<?= $cat['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                    <button type="submit" class="w-8 h-8 rounded bg-cyan-50 text-cyan-600 flex items-center justify-center hover:bg-cyan-600 hover:text-white transition" title="Hapus">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-tags text-4xl mb-3 text-gray-200"></i>
                            <p>Tidak ada kategori yang ditemukan dalam basis data.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>

