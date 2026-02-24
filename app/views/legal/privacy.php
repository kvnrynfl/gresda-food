<?php 
$page_title = "Kebijakan Privasi";
$back_link = BASEURL . "/";
ob_start(); 
?>

<!-- Header -->
<div class="relative bg-secondary text-white pt-20 pb-16 overflow-hidden">
    <!-- Decorative background blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[150%] bg-gradient-to-b from-primary to-transparent rounded-full blur-3xl transform rotate-45"></div>
        <div class="absolute top-[40%] -left-[20%] w-[60%] h-[100%] bg-gradient-to-t from-cyan-600 to-transparent rounded-full blur-3xl transform -rotate-12"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Kebijakan Privasi</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Transparansi dan keamanan data Anda adalah komitmen utama kami di Gresda Food.</p>
    </div>
</div>

<!-- Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14 flex flex-col md:flex-row gap-12">
    <!-- Table of Contents Sidebar -->
    <div class="md:w-1/4 hidden md:block">
        <div class="sticky top-24 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h4 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Daftar Isi</h4>
            <ul class="space-y-3 text-sm font-medium text-gray-500">
                <li><a href="#info-dikumpulkan" class="hover:text-primary transition">1. Informasi yang Dikumpulkan</a></li>
                <li><a href="#penggunaan-data" class="hover:text-primary transition">2. Penggunaan Data</a></li>
                <li><a href="#perlindungan-keamanan" class="hover:text-primary transition">3. Perlindungan & Keamanan</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content Policy -->
    <div class="md:w-3/4 prose prose-cyan max-w-none text-gray-700 leading-relaxed bg-white p-8 sm:p-12 rounded-3xl shadow-sm border border-gray-50">
        <p class="text-lg font-medium mb-8 text-gray-800">Kebijakan Privasi ini menjelaskan bagaimana Gresda Food mengumpulkan, menggunakan, mengungkapkan, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan layanan platform pemesanan makanan kami.</p>
        
        <h3 id="info-dikumpulkan" class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3 pt-4">
        <span class="bg-cyan-100 text-cyan-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span> 
        Informasi yang Kami Kumpulkan
    </h3>
    <p class="mb-3">Kami mengumpulkan berbagai jenis informasi pribadi berkaitan dengan Anda untuk menyediakan dan meningkatkan kualitas layanan. Ini termasuk:</p>
    <div class="space-y-4 mb-8 text-gray-600">
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:border-cyan-200 transition-colors">
            <strong class="text-gray-900 block mb-1">Data Akun & Profil</strong> 
            Nama Lengkap, Username, Alamat Email, Profil Foto, dan Kata Sandi (yang dienkripsi dengan standar Bcrypt).
        </div>
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:border-cyan-200 transition-colors">
            <strong class="text-gray-900 block mb-1">Data Pemesanan & Pembayaran</strong> 
            Detail Histori pesanan, alamat tujuan pengiriman, nomor rekening pembayaran, serta bukti transfer pesanan. <br>
            <em class="text-xs mt-1 block text-cyan-700">* Catatan: Kami tidak mengumpulkan/menyimpan password atau PIN perbankan pelanggan.</em>
        </div>
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:border-cyan-200 transition-colors">
            <strong class="text-gray-900 block mb-1">Pesan & Ulasan</strong>
            Pesan layanan keluhan yang dikirim via kotak kontak, komentar serta penilaian (rating) yang Anda berikan atas pesanan.
        </div>
    </div>


    <h3 id="penggunaan-data" class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3 pt-4">
        <span class="bg-cyan-100 text-cyan-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span> 
        Bagaimana Kami Menggunakan Data Anda
    </h3>
    <p class="mb-3">Data Anda hanya akan digunakan untuk hal-hal inti berikut yang menguntungkan Anda langsung:</p>
    <ul class="space-y-3 list-disc list-outside ml-6 text-gray-600">
        <li class="pl-2">Menyediakan, memelihara, dan mempersonalisasi layanan pemesanan makanan.</li>
        <li class="pl-2">Memproses status dan konfirmasi pembayaran agar Anda dapat dilayani secara tepat waktu.</li>
        <li class="pl-2">Kurir dapat menelepon/mencarikan alamat antar langsung dari rincian order yang dicantumkan.</li>
        <li class="pl-2">Menangani masalah keamanan, memblokir upaya penipuan, serta memonitor integritas <em>database</em> (Mencegah SQL/XSS).</li>
    </ul>

    <h3 id="perlindungan-keamanan" class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3 pt-4">
        <span class="bg-cyan-100 text-cyan-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span> 
        Perlindungan & Keamanan Data
    </h3>
    <ul class="space-y-3 list-disc list-outside ml-6 text-gray-600 mb-8">
        <li class="pl-2">Gresda Food mengimplementasikan standar keamanan <strong>Token Bebas Tempaan Bawah Titik (CSRF)</strong> pada setiap formulir yang Anda kirim demi menghindari kebocoran peretas.</li>
        <li class="pl-2">Kami mengimplementasikan metode Filter Data berlapis pada inti framework untuk menyaring inputan.</li>
        <li class="pl-2">Pengunggahan bukti struk dirancang dengan pemotongan esensi kode tersembunyi lewat pengecekan ketat (MIME Check).</li>
        <li class="pl-2">Kami tidak memperjualbelikan database pribadi seluruh pengguna ke Pihak Ketiga dengan alasan komersial apa pun.</li>
    </ul>
    </div>
</div>

<div class="bg-gray-50 px-10 py-6 border-t border-gray-100 text-center text-sm text-gray-500">
    <p>&copy; <?= date('Y') ?> Gresda Food & Beverage. Kebijakan Privasi Berlaku Secara Sah.</p>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
