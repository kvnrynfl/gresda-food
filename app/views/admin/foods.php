<?php 
$title = "Kelola Menu Makanan";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
        <h3 class="text-lg font-bold text-gray-800">Semua Item Menu</h3>
        <div class="flex gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Cari makanan..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition">
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
            </div>
            <a href="<?= BASEURL ?>/admin/createFood" class="px-4 py-2 bg-cyan-600 text-white rounded-lg shadow-sm hover:bg-cyan-700 transition flex items-center justify-center gap-2 text-sm font-bold whitespace-nowrap">
                <i class="fas fa-plus"></i> Tambah Menu Baru
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                    <td class="px-6 py-4 w-16">ID</td>
                    <td class="px-6 py-4">Item Makanan</td>
                    <td class="px-6 py-4">Harga</td>
                    <td class="px-6 py-4">Kategori</td>
                    <td class="px-6 py-4">Dibuat / Diperbarui</td>
                    <td class="px-6 py-4">Status</td>
                    <td class="px-6 py-4 text-center">Aksi</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($foods)): foreach($foods as $food): ?>
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono">#<?= $food['food_id'] ?></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 shadow-sm border border-gray-200">
                                    <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($food['image_name']) ?>" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($food['name'] ?? 'Food') ?>&background=random&color=fff'">
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800"><?= htmlspecialchars($food['name']) ?></div>
                                    <div class="text-xs text-gray-500 line-clamp-1 w-48"><?= htmlspecialchars($food['description']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-700">Rp <?= number_format($food['price'] ?? 0, 0, ',', '.') ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <span class="bg-gray-100 px-3 py-1 rounded text-xs font-semibold uppercase tracking-wide"><?= htmlspecialchars($food['category']) ?></span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 font-mono">
                            <div class="mb-1 text-gray-600"><i class="fas fa-plus-circle text-green-500 mr-1"></i> <?= date('d M y H:i', strtotime($food['created_at'])) ?></div>
                            <div><i class="fas fa-edit text-blue-400 mr-1"></i> <?= date('d M y H:i', strtotime($food['updated_at'])) ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if ($food['active'] === 'Yes'): ?>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-xs"><i class="fas fa-check-circle mr-1"></i> Aktif</span>
                            <?php else: ?>
                                <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full font-bold text-xs"><i class="fas fa-times-circle mr-1"></i> Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="<?= BASEURL ?>/admin/editFood/<?= $food['food_id'] ?>" class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="<?= BASEURL ?>/admin/deleteFood/<?= $food['food_id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus <?= htmlspecialchars($food['name']) ?>?');">
                                    <button type="submit" class="w-8 h-8 rounded bg-cyan-50 text-cyan-600 flex items-center justify-center hover:bg-cyan-600 hover:text-white transition shadow-sm" title="Hapus">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-hamburger text-3xl text-gray-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-600 mb-1">Tidak Ada Item Menu Ditemukan</h3>
                            <p class="text-sm">Saat ini tidak ada makanan yang ditambahkan ke basis data.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Simple Pagination Footer Placeholder -->
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
        <span class="text-sm text-gray-500">Menampilkan <span class="font-bold text-gray-700">1</span> hingga <span class="font-bold text-gray-700">10</span> dari <span class="font-bold text-gray-700">50</span> entri</span>
        <div class="flex gap-1">
            <button class="px-3 py-1 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded text-sm disabled:opacity-50">Seb</button>
            <button class="px-3 py-1 border border-cyan-500 bg-cyan-50 text-cyan-600 rounded text-sm font-bold cursor-default">1</button>
            <button class="px-3 py-1 border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 rounded text-sm">2</button>
            <button class="px-3 py-1 border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 rounded text-sm">3</button>
            <button class="px-3 py-1 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded text-sm">Sel</button>
        </div>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>

