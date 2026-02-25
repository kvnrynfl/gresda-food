<?php 
$title = "Kelola Pengguna";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Pelanggan Terdaftar</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                    <td class="px-6 py-4 w-16">ID</td>
                    <td class="px-6 py-4">Nama Pengguna</td>
                    <td class="px-6 py-4">Alamat Email</td>
                    <td class="px-6 py-4">Terdaftar Pada</td>
                    <td class="px-6 py-4 text-center">Aksi</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($users)): foreach($users as $user): ?>
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono">#<?= $user['id'] ?></td>
                        <td class="px-6 py-4 font-bold text-gray-800 flex items-center gap-3">
                            <img src="<?= BASEURL ?>/images/users/<?= htmlspecialchars($user['img_user'] ?? 'default.jpg') ?>" class="w-8 h-8 rounded-full border border-gray-200" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user['username']) ?>&background=random&color=fff'">
                            <?= htmlspecialchars($user['username']) ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono"><?= date('d M Y, H:i', strtotime($user['created_at'])) ?></td>
                        <td class="px-6 py-4 text-center">
                            <form action="<?= BASEURL ?>/admin/deleteUser/<?= $user['id'] ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan <?= htmlspecialchars($user['username']) ?>?');">
                                <button type="submit" class="w-8 h-8 rounded bg-cyan-50 text-cyan-600 inline-flex items-center justify-center hover:bg-cyan-600 hover:text-white transition shadow-sm" title="Hapus Akun">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                            <p>Tidak ada pelanggan terdaftar ditemukan.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>

