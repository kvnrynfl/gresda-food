<?php 
$title = "Edit Profil Admin";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="<?= BASEURL ?>/admin/admins" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-200"></i>
        </a>
        <h2 class="text-2xl font-bold text-white">Edit Profil: <?= htmlspecialchars($admin['username']) ?></h2>
    </div>
</div>

<div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden shadow-sm max-w-xl">
    <div class="p-6">
        <form action="<?= BASEURL ?>/admin/editAdmin/<?= $admin['id'] ?>" method="POST" class="space-y-6">
            <?= CSRF::getTokenField() ?>
            
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($admin['full_name']) ?>" required class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-slate-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Pengguna</label>
                <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" required class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-slate-500">
            </div>

            <div class="pt-4 border-t border-slate-700 flex justify-end gap-3">
                <a href="<?= BASEURL ?>/admin/admins" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-300 bg-slate-700 hover:bg-slate-600 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>
