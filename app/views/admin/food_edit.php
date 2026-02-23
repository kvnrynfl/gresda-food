<?php 
$title = "Edit Item Makanan";
include '../app/views/layouts/admin_header.php'; 
?>

<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="<?= BASEURL ?>/admin/foods" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white transition group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-200"></i>
        </a>
        <h2 class="text-2xl font-bold text-white">Edit Item Makanan: <?= htmlspecialchars($food['name']) ?></h2>
    </div>
</div>

<div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden shadow-sm max-w-3xl">
    <div class="p-6">
        <form action="<?= BASEURL ?>/admin/editFood/<?= $food['food_id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= CSRF::getTokenField() ?>
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($food['image_name']) ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Makanan</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($food['name']) ?>" required class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-slate-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Kategori</label>
                    <select name="category" required class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori</option>
                        <?php if(!empty($categories)): foreach($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['category']) ?>" <?= ($cat['category'] == $food['category']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Harga (Rp)</label>
                <input type="number" step="1" name="price" value="<?= htmlspecialchars($food['price']) ?>" required class="w-full md:w-1/2 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-slate-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-slate-500"><?= htmlspecialchars($food['description']) ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Gambar Makanan</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-lg bg-slate-900 border border-slate-700 flex items-center justify-center text-slate-500 overflow-hidden" id="imagePreviewContainer">
                            <?php if(!empty($food['image_name'])): ?>
                                <img src="<?= BASEURL ?>/uploads/foods/<?= htmlspecialchars($food['image_name']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fas fa-image text-2xl"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition">
                            <p class="text-xs text-slate-500 mt-2">Biarkan kosong untuk mempertahankan gambar saat ini. Maks 2MB.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Status Aktif</label>
                    <div class="flex gap-4 mt-2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="active" value="Yes" <?= ($food['active'] == 'Yes') ? 'checked' : '' ?> class="form-radio text-blue-600 bg-slate-900 border-slate-700 focus:ring-blue-500 focus:ring-offset-slate-800">
                            <span class="ml-2 text-white text-sm">Ya (Terdaftar)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="active" value="No" <?= ($food['active'] == 'No') ? 'checked' : '' ?> class="form-radio text-blue-600 bg-slate-900 border-slate-700 focus:ring-blue-500 focus:ring-offset-slate-800">
                            <span class="ml-2 text-white text-sm">Tidak (Tersembunyi)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-700 flex justify-end gap-3">
                <a href="<?= BASEURL ?>/admin/foods" class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-300 bg-slate-700 hover:bg-slate-600 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        if(e.target.files && e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreviewContainer').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>

<?php include '../app/views/layouts/admin_footer.php'; ?>
