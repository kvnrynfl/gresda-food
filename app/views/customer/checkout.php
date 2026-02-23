<?php include '../app/views/layouts/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center gap-3 mb-8 text-sm text-gray-500 font-medium">
            <a href="<?= BASEURL ?>/customer/cart" class="hover:text-primary transition"><i class="fas fa-shopping-cart"></i> Keranjang</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900">Pembayaran</span>
        </div>

        <h2 class="text-3xl font-extrabold text-secondary mb-8">Selesaikan Pembayaran</h2>

        <form action="<?= BASEURL ?>/customer/processCheckout" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <?= CSRF::getTokenField() ?>
            
            <div class="lg:col-span-2 space-y-8">
                <!-- Shipping Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-map-marker-alt text-primary"></i> Alamat Pengiriman</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Penerima</label>
                            <input type="text" name="recipient_name" required value="<?= htmlspecialchars($_SESSION['username']) ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone_number" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap Pengiriman</label>
                            <textarea name="address" rows="3" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-wallet text-primary"></i> Metode Pembayaran</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Simulated Payment Options -->
                        <label class="relative border border-gray-200 rounded-xl p-4 flex flex-col items-center cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-cyan-50 transition">
                            <input type="radio" name="payment_method" value="Bank BCA" class="absolute opacity-0 peer" required>
                            <div class="w-full h-full absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary pointer-events-none"></div>
                            <img src="<?= BASEURL ?>/images/payment/bca.png" alt="BCA" class="h-8 mb-2 object-contain" onerror="this.src='https://via.placeholder.com/80x30?text=BCA'">
                            <span class="text-sm font-medium text-gray-700">Bank BCA</span>
                        </label>
                        
                        <label class="relative border border-gray-200 rounded-xl p-4 flex flex-col items-center cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-cyan-50 transition">
                            <input type="radio" name="payment_method" value="Bank BNI" class="absolute opacity-0 peer">
                            <div class="w-full h-full absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary pointer-events-none"></div>
                            <img src="<?= BASEURL ?>/images/payment/bni.png" alt="BNI" class="h-8 mb-2 object-contain" onerror="this.src='https://via.placeholder.com/80x30?text=BNI'">
                            <span class="text-sm font-medium text-gray-700">Bank BNI</span>
                        </label>

                        <label class="relative border border-gray-200 rounded-xl p-4 flex flex-col items-center cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-cyan-50 transition">
                            <input type="radio" name="payment_method" value="Gopay" class="absolute opacity-0 peer">
                            <div class="w-full h-full absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary pointer-events-none"></div>
                            <img src="<?= BASEURL ?>/images/payment/gopay.png" alt="Gopay" class="h-8 mb-2 object-contain" onerror="this.src='https://via.placeholder.com/80x30?text=Gopay'">
                            <span class="text-sm font-medium text-gray-700">GoPay</span>
                        </label>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 mb-6">
                        <p class="text-sm tracking-wide text-gray-600 mb-2">Silakan transfer persis ke:</p>
                        <p class="text-xl font-mono font-bold text-gray-900 tracking-wider">1234 5678 9012 3456</p>
                        <p class="text-sm font-semibold text-gray-500">A/N Gresda Food & Beverage</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Unggah Bukti Pembayaran (Struk)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition relative group">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 group-hover:text-primary transition mb-3"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-cyan-500 focus-within:outline-none">
                                        <span>Unggah file</span>
                                        <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/jpeg, image/png, image/jpg" required>
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF hingga 5MB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validation Action -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Konfirmasi Pesanan</h3>
                    
                    <button type="submit" class="w-full flex justify-center items-center py-4 bg-green-600 text-white rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-lg gap-2 shadow-green-500/30">
                        <i class="fas fa-check-circle"></i> Selesaikan Pembayaran
                    </button>
                    
                    <div class="mt-6 text-xs text-gray-400 text-center leading-relaxed">
                        Dengan menyelesaikan pesanan ini, Anda menyetujui <a href="#" class="text-primary hover:underline">Ketentuan Layanan</a> dan <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a> kami.
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>

