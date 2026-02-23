<?php include '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="bg-secondary text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Tentang Gresda Food</h1>
        <p class="text-xl text-gray-300">Temukan kisah kami, renjana kami, dan dedikasi kami pada keunggulan kuliner.</p>
    </div>
</div>

<!-- Main Content -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-12 items-center">
        <div class="md:w-1/2">
            <img src="<?= BASEURL ?>/images/aesthetic/home-bg.jpg" alt="About Gresda" class="rounded-2xl shadow-2xl w-full object-cover h-[500px]" onerror="this.src='https://images.unsplash.com/photo-1514933651103-005eec06c04b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80'">
        </div>
        <div class="md:w-1/2">
            <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">Kisah Kami</h2>
            <h3 class="text-3xl font-extrabold text-secondary mb-6">Warisan Rasa Premium</h3>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Didirikan dengan visi untuk membawa hidangan steak kelas dunia dan sajian barat yang lezat ke komunitas kami, Gresda Food & Beverage telah berkembang menjadi destinasi bersantap utama. Kami percaya bahwa hidangan yang luar biasa bukan sekadar makanan; ini adalah sebuah pengalaman.
            </p>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Komitmen kami dimulai dari bahan-bahannya. Kami hanya mengambil daging sapi impor terbaik, sayuran organik yang ditanam secara lokal, dan rempah-rempah otentik. Para koki ahli kami meracik setiap hidangan dengan teliti, menggabungkan teknik tradisional dengan inovasi modern untuk memastikan setiap gigitan terasa luar biasa.
            </p>
            
            <div class="grid grid-cols-2 gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-cyan-100 flex items-center justify-center text-primary text-xl">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">Kualitas Premium</h4>
                        <p class="text-sm text-gray-500">Hanya yang terbaik</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-cyan-100 flex items-center justify-center text-primary text-xl">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">Segar Setiap Hari</h4>
                        <p class="text-sm text-gray-500">Hasil bumi lokal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
