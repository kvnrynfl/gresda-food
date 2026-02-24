<?php include '../app/views/layouts/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="<?= BASEURL ?>/customer/orders" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 shadow-sm border border-gray-200 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Pembayaran Pesanan</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-white border-b border-gray-100 px-8 py-6 flex flex-col sm:flex-row justify-between sm:items-center gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">ID Pesanan</p>
                    <h2 class="text-2xl font-black text-gray-900 font-mono tracking-tight leading-none">#<?= htmlspecialchars($order_id) ?></h2>
                </div>
                <div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">Total Tagihan</p>
                        <span class="text-2xl font-extrabold text-blue-600">Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-200 mb-8 flex gap-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-yellow-800 mb-1">Menunggu Pembayaran</h4>
                        <p class="text-sm text-yellow-700">Pesanan Anda telah dibuat, tetapi kami membutuhkan bukti pembayaran sebelum dapat memprosesnya lebih lanjut.</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mb-8 max-w-md mx-auto text-center">
                    <p class="text-sm tracking-wide text-gray-600 mb-3">Silakan transfer persis sebesar <strong class="text-gray-900">Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?></strong> ke rekening berikut:</p>
                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm inline-block w-full">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1"><?= htmlspecialchars($payment_info['metode'] ?? 'Bank') ?></p>
                        <p class="text-2xl font-mono font-black text-gray-900 tracking-wider"><?= htmlspecialchars($payment_info['rekening_number'] ?? '-') ?></p>
                        <p class="text-sm font-semibold text-gray-500 mt-1">A/N <?= htmlspecialchars($payment_info['an'] ?? '-') ?></p>
                    </div>
                </div>

                <form id="payment-form" action="<?= BASEURL ?>/customer/processPayment" method="POST" enctype="multipart/form-data">
                    <?= CSRF::getTokenField() ?>
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">

                    <div class="mb-6">
                        <label for="rekening_name" class="block text-sm font-bold text-gray-800 mb-2">Nama Pemilik Rekening Pengirim <span class="text-red-500">*</span></label>
                        <input type="text" id="rekening_name" name="rekening_name" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        <p class="text-xs text-gray-500 mt-2">Nama yang tertera pada rekening/akun asal transfer.</p>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-800 mb-3">Unggah Bukti Transfer Transaksi <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition relative group" id="upload-container">
                            <div class="space-y-2 text-center" id="upload-content">
                                <i class="fas fa-receipt text-5xl text-blue-200 group-hover:text-blue-500 transition mb-4"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-bold text-blue-600 hover:text-blue-700 px-3 py-1 shadow-sm border border-blue-100 focus-within:outline-none">
                                        <span>Pilih Gambar</span>
                                        <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(this);" required>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    Mendukung format gambar PNG, JPG, JPEG (Maks. 5MB)
                                </p>
                            </div>
                            <div id="image-preview-container" class="hidden w-full flex-col items-center">
                                <img id="image-preview" src="#" alt="Preview" class="max-h-64 rounded-xl mb-4 object-contain shadow-md border border-gray-200">
                                <button type="button" onclick="removeImage();" class="text-sm text-red-600 hover:bg-red-50 font-bold px-4 py-2 rounded-lg transition border border-red-200"><i class="fas fa-sync-alt mr-2"></i> Ganti Gambar</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center items-center py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg gap-2 shadow-blue-500/30">
                        <i class="fas fa-check-circle"></i> Konfirmasi Pembayaran
                    </button>
                    
                    <p class="text-center text-xs text-gray-400 mt-4 leading-relaxed max-w-sm mx-auto">Tim kami akan memperbarui status pesanan Anda segera setelah dana kami terima dan diverifikasi.</p>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('upload-content').classList.add('hidden');
            var container = document.getElementById('image-preview-container');
            container.classList.remove('hidden');
            container.classList.add('flex');
            document.getElementById('image-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    document.getElementById('payment_proof').value = "";
    document.getElementById('image-preview').src = "#";
    var container = document.getElementById('image-preview-container');
    container.classList.add('hidden');
    container.classList.remove('flex');
    document.getElementById('upload-content').classList.remove('hidden');
}
</script>

<?php include '../app/views/layouts/footer.php'; ?>
