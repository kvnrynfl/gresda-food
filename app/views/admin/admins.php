<?php 
$title = "Kelola Administrator";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Personel Admin</h3>
        <a href="<?= BASEURL ?>/admin/createAdmin" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 transition flex items-center gap-2 text-sm font-bold">
            <i class="fas fa-user-shield"></i> Tambah Admin Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                    <td class="px-6 py-4 w-16">ID</td>
                    <td class="px-6 py-4">Nama Lengkap</td>
                    <td class="px-6 py-4">Nama Pengguna</td>
                    <td class="px-6 py-4 text-center">Aksi</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(!empty($admins)): foreach($admins as $admin): ?>
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono">#<?= $admin['id'] ?></td>
                        <td class="px-6 py-4 font-bold text-gray-800">
                            <?= htmlspecialchars($admin['full_name']) ?>
                            <?php if($admin['id'] == $_SESSION['admin_id']): ?>
                                <span class="ml-2 bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-bold">Anda</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">@<?= htmlspecialchars($admin['username']) ?></td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="<?= BASEURL ?>/admin/editAdmin/<?= $admin['id'] ?>" class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit Profil">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="<?= BASEURL ?>/admin/editAdminPassword/<?= $admin['id'] ?>" class="w-8 h-8 rounded bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-500 hover:text-white transition shadow-sm" title="Ubah Kata Sandi">
                                    <i class="fas fa-key text-xs"></i>
                                </a>
                                <?php if($admin['id'] != $_SESSION['admin_id']): ?>
                                <form action="<?= BASEURL ?>/admin/deleteAdmin/<?= $admin['id'] ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Admin <?= htmlspecialchars($admin['username']) ?>?');">
                                    <button type="submit" class="w-8 h-8 rounded bg-cyan-50 text-cyan-600 inline-flex items-center justify-center hover:bg-cyan-600 hover:text-white transition shadow-sm" title="Hapus Admin">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-user-shield text-4xl mb-3 text-gray-300"></i>
                            <p>Tidak ada personel admin ditemukan.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>

