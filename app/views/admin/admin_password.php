<?php 
$title = "Ubah Kata Sandi Admin";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="<?= BASEURL ?>/admin/admins" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-200"></i>
        </a>
        <h2 class="text-2xl font-bold text-white">Ubah Kata Sandi untuk <?= htmlspecialchars($admin['username']) ?></h2>
    </div>
</div>

<div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden shadow-sm max-w-xl">
    <div class="p-6">
        <form action="<?= BASEURL ?>/admin/editAdminPassword/<?= $admin['id'] ?>" method="POST" class="space-y-6">
            <?= CSRF::getTokenField() ?>
            
            <div class="p-4 bg-yellow-900/40 border border-yellow-700/50 rounded-lg text-yellow-200 text-sm flex items-start gap-3">
                <i class="fas fa-exclamation-triangle mt-1"></i>
                <p>Anda sedang mengubah kredensial keamanan untuk akun administratif. Pastikan Anda menyampaikan kata sandi baru secara aman.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Kata Sandi Baru</label>
                <input type="password" name="new_password" required minlength="8" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition placeholder-slate-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="confirm_password" required minlength="8" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition placeholder-slate-500">
            </div>

            <div class="pt-4 border-t border-slate-700 flex justify-end gap-3">
                <a href="<?= BASEURL ?>/admin/admins" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-300 bg-slate-700 hover:bg-slate-600 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-yellow-600 hover:bg-yellow-700 shadow-lg shadow-yellow-500/20 transition">Perbarui Kata Sandi</button>
            </div>
        </form>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>
