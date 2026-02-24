<?php include '../app/views/layouts/header.php'; ?>

<div class="bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-500 to-green-500 px-10 py-12 text-center">
                <h1 class="text-4xl font-extrabold text-white mb-4">Kebijakan Privasi</h1>
                <p class="text-green-50 text-lg md:px-16">Transparansi dan keamanan data Anda adalah komitmen utama kami di Gresda Food.</p>
            </div>

            <!-- Content -->
            <div class="p-10 md:p-14 prose prose-green max-w-none text-gray-700 leading-relaxed">
                <p class="text-lg font-medium mb-8 text-gray-800">Kebijakan Privasi ini menjelaskan bagaimana Gresda Food  mengumpulkan, menggunakan, mengungkapkan, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan layanan platform pemesanan makanan kami.</p>
                
                <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3">
                    <span class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span> 
                    Informasi yang Kami Kumpulkan
                </h3>
                <p class="mb-3">Kami mengumpulkan berbagai jenis informasi pribadi berkaitan dengan Anda untuk menyediakan dan meningkatkan kualitas layanan. Ini termasuk:</p>
                <div class="space-y-4 mb-8 text-gray-600">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <strong class="text-gray-900 block mb-1">Data Akun & Profil</strong> 
                        Nama Lengkap, Username, Alamat Email, Profil Foto, dan Kata Sandi (yang dienkripsi dengan standar Bcrypt).
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <strong class="text-gray-900 block mb-1">Data Pemesanan & Pembayaran</strong> 
                        Detail Histori pesanan, alamat tujuan pengiriman, nomor rekening pembayaran, serta bukti transfer pesanan. <br>
                        <em>Catatan: Kami tidak mengumpulkan/menyimpan password atau PIN perbankan pelanggan.</em>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <strong class="text-gray-900 block mb-1">Pesan & Ulasan</strong>
                        Pesan layanan keluhan yang dikirim via kotak kontak, komentar serta penilaian (rating) yang Anda berikan atas pesanan.
                    </div>
                </div>


                <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3">
                    <span class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span> 
                    Bagaimana Kami Menggunakan Data Anda
                </h3>
                <p class="mb-3">Data Anda hanya akan digunakan untuk hal-hal inti berikut yang menguntungkan Anda langsung:</p>
                <ul class="space-y-3 list-disc list-outside ml-6 text-gray-600">
                    <li class="pl-2">Menyediakan, memelihara, dan mempersonalisasi layanan pemesanan makanan.</li>
                    <li class="pl-2">Memproses status dan konfirmasi pembayaran agar Anda dapat dilayani secara tepat waktu.</li>
                    <li class="pl-2">Kurir dapat menelepon/mencarikan alamat antar langsung dari rincian order yang dicantumkan.</li>
                    <li class="pl-2">Menangani masalah keamanan, memblokir upaya penipuan, serta memonitor integritas <em>database</em> (Mencegah SQL/XSS).</li>
                </ul>

                <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3">
                    <span class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span> 
                    Perlindungan & Keamanan Data
                </h3>
                <ul class="space-y-3 list-disc list-outside ml-6 text-gray-600 mb-8">
                    <li class="pl-2">Gresda Food mengimplementasikan standar keamanan <strong>Token Bebas Tempaan Bawah Titik (CSRF)</strong> pada setiap formulir yang Anda kirim demi menghindari kebocoran peretas.</li>
                    <li class="pl-2">Kami mengimplementasikan metode Filter Data berlapis pada inti framework untuk menyaring inputan.</li>
                    <li class="pl-2">Pengunggahan bukti struk dirancang dengan pemotongan esensi kode tersembunyi lewat pengecekan ketat (MIME Check).</li>
                    <li class="pl-2">Kami tidak memperjualbelikan database pribadi seluruh pengguna ke Pihak Ketiga dengan alasan komersial apa pun.</li>
                </ul>
            </div>
            
            <div class="bg-gray-50 px-10 py-6 border-t border-gray-100 text-center text-sm text-gray-500">
                <p>&copy; <?= date('Y') ?> Gresda Food & Beverage. Kebijakan Privasi Berlaku Secara Sah.</p>
            </div>
        </div>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>
