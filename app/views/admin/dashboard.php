<?php 
$title = "Ringkasan";
include '../app/views/layouts/admin_header.php'; 
?>

<!-- Stats Grid -->
<div class="grid grid-cols-1 select-none md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center transform hover:-translate-y-1 transition duration-300 hover:shadow-md cursor-pointer group">
        <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
            <i class="fas fa-users text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pengguna</p>
            <p class="text-3xl font-bold text-gray-800">120</p>
        </div>
    </div>
    <!-- Stat Card 2 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center transform hover:-translate-y-1 transition duration-300 hover:shadow-md cursor-pointer group">
        <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4 group-hover:bg-green-600 group-hover:text-white transition">
            <i class="fas fa-tags text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Kategori</p>
            <p class="text-3xl font-bold text-gray-800"><?= $total_categories ?? 0 ?></p>
        </div>
    </div>
    <!-- Stat Card 3 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center transform hover:-translate-y-1 transition duration-300 hover:shadow-md cursor-pointer group">
        <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4 group-hover:bg-purple-600 group-hover:text-white transition">
            <i class="fas fa-hamburger text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Menu Makanan</p>
            <p class="text-3xl font-bold text-gray-800"><?= $total_foods ?? 0 ?></p>
        </div>
    </div>
    <!-- Stat Card 4 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center transform hover:-translate-y-1 transition duration-300 hover:shadow-md cursor-pointer group">
        <div class="p-3 rounded-full bg-cyan-50 text-cyan-600 mr-4 group-hover:bg-cyan-600 group-hover:text-white transition">
            <i class="fas fa-chart-line text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pesanan Aktif</p>
            <p class="text-3xl font-bold text-gray-800">14</p>
        </div>
    </div>
</div>

<!-- Extra Layout Placeholder -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
        <h3 class="text-lg font-bold text-gray-800">Aktivitas Sistem Terbaru</h3>
        <button class="text-sm text-cyan-500 hover:underline">Lihat Semua</button>
    </div>
    <div class="text-center text-gray-400 py-10">
        <i class="fas fa-chart-bar text-4xl mb-3 text-gray-300"></i>
        <p>Grafik Analitik Segera Hadir di V2.1</p>
    </div>
</div>

<?php include '../app/views/layouts/admin_footer.php'; ?>

