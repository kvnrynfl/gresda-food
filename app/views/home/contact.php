<?php include '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="bg-secondary text-white pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Hubungi Kami</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Kami senang mendengar dari Anda. Hubungi kami untuk reservasi atau pertanyaan.</p>
    </div>
</div>

<!-- Main Content -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            
            <!-- Contact Info -->
            <div class="md:col-span-1 space-y-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-cyan-100 flex items-center justify-center text-primary text-2xl mb-4">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Lokasi Kami</h4>
                    <p class="text-gray-600">Jalan Kuliner 123,<br>Distrik Makanan, Kota 10110</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-cyan-100 flex items-center justify-center text-primary text-2xl mb-4">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Nomor Telepon</h4>
                    <p class="text-gray-600">+62 (821) 2708-3486<br>+62 (812) 9876-5432</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-cyan-100 flex items-center justify-center text-primary text-2xl mb-4">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Alamat Email</h4>
                    <p class="text-gray-600">support@gresdafood.com</p>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="md:col-span-2 bg-white p-10 rounded-2xl shadow-lg">
                <h3 class="text-3xl font-extrabold text-secondary mb-6">Kirim Pesan</h3>
                <form action="<?= BASEURL ?>/contact/submit" method="POST" class="space-y-6">
                    <?= CSRF::getTokenField() ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition" placeholder="Budi Santoso" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition" placeholder="budi@example.com" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea name="message" rows="5" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition" placeholder="Ada yang bisa kami bantu?" required></textarea>
                    </div>
                    <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-xl hover:bg-cyan-700 transition transform hover:-translate-y-1 shadow-lg">
                        Kirim Pesan
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
