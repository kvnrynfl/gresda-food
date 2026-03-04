<?php include '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="relative bg-secondary text-white pt-20 pb-16 overflow-hidden">
    <!-- Decorative background blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[150%] bg-gradient-to-b from-primary to-transparent rounded-full blur-3xl transform rotate-45"></div>
        <div class="absolute top-[40%] -left-[20%] w-[60%] h-[100%] bg-gradient-to-t from-cyan-600 to-transparent rounded-full blur-3xl transform -rotate-12"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Hubungi Kami</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Kami senang mendengar dari Anda. Hubungi kami untuk reservasi atau pertanyaan.</p>
    </div>
</div>

<!-- Main Content -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            
            <!-- Location Map & Info -->
            <div class="md:col-span-1 space-y-6" data-aos="fade-right" data-aos-duration="800">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-64 relative group">
                    <!-- Google Maps Embed -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.3340579730246!2d107.76014491035544!3d-6.969851693006456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c4a16ed6a2ef%3A0xc392fd6b2db3c18b!2sRancaekek%2C%20Bandung%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1714574929290!5m2!1sen!2sid" 
                        class="absolute inset-0 w-full h-full border-0" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-300 pointer-events-none"></div>
                </div>

                <div class="bg-gradient-to-br from-cyan-600 to-primary p-8 rounded-2xl shadow-lg text-white">
                    <h4 class="text-xl font-bold mb-6">Informasi Kontak</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <i class="fas fa-map-marker-alt mt-1.5 text-cyan-200"></i>
                            <span>Rancaekek, Kab. Bandung, Jawa Barat</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <i class="fas fa-phone text-cyan-200"></i>
                            <span>+62 821-2708-3486</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <i class="fas fa-envelope text-cyan-200"></i>
                            <span>support@gresdafood.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="md:col-span-2 bg-white p-10 rounded-2xl shadow-lg" data-aos="fade-left" data-aos-delay="200" data-aos-duration="800">
                <h3 class="text-3xl font-extrabold text-secondary mb-6">Kirim Pesan</h3>
                <form action="<?= BASEURL ?>/contact/send" method="POST" class="space-y-6">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                        <input type="text" name="subject" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-primary focus:border-primary transition" placeholder="Pertanyaan mengenai..." required>
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
