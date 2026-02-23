<?php include '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="bg-secondary text-white pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Tentang Gresda Food</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Temukan kisah kami, renjana kami, dan dedikasi kami pada keunggulan kuliner.</p>
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

    <!-- Visi dan Nilai Kami -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
        <div class="text-center mb-16">
            <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">Pondasi Kami</h2>
            <h3 class="text-4xl font-extrabold text-secondary">Visi & Nilai Inti</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Nilai 1 -->
            <div class="bg-gray-50 rounded-2xl p-8 text-center hover:bg-white hover:shadow-xl transition relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-100 rounded-bl-full -mr-10 -mt-10 opacity-50 transition group-hover:bg-primary group-hover:scale-110 duration-500"></div>
                <i class="fas fa-utensils text-4xl text-primary mb-6 relative z-10 group-hover:text-white transition duration-500"></i>
                <h4 class="text-2xl font-bold text-gray-800 mb-4 relative z-10">Visi Kuliner</h4>
                <p class="text-gray-600 relative z-10 leading-relaxed">Menjadi restoran yang diakui secara nasional sebagai standar emas dalam kualitas makanan barat dengan sentuhan cita rasa berkelas.</p>
            </div>
            <!-- Nilai 2 -->
            <div class="bg-gray-50 rounded-2xl p-8 text-center hover:bg-white hover:shadow-xl transition relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-100 rounded-bl-full -mr-10 -mt-10 opacity-50 transition group-hover:bg-primary group-hover:scale-110 duration-500"></div>
                <i class="fas fa-heart text-4xl text-primary mb-6 relative z-10 group-hover:text-white transition duration-500"></i>
                <h4 class="text-2xl font-bold text-gray-800 mb-4 relative z-10">Pelayanan dari Hati</h4>
                <p class="text-gray-600 relative z-10 leading-relaxed">Setiap pelanggan adalah tamu terhormat. Kami percaya pelayanan yang bersahabat, tulus, dan kekeluargaan akan meninggalkan kenangan abadi.</p>
            </div>
            <!-- Nilai 3 -->
            <div class="bg-gray-50 rounded-2xl p-8 text-center hover:bg-white hover:shadow-xl transition relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-100 rounded-bl-full -mr-10 -mt-10 opacity-50 transition group-hover:bg-primary group-hover:scale-110 duration-500"></div>
                <i class="fas fa-bullseye text-4xl text-primary mb-6 relative z-10 group-hover:text-white transition duration-500"></i>
                <h4 class="text-2xl font-bold text-gray-800 mb-4 relative z-10">Kenyamanan Optimal</h4>
                <p class="text-gray-600 relative z-10 leading-relaxed">Kami mendedikasikan arsitektur ruang, estetika, dan fasilitas yang mendukung obrolan santai sekaligus kenyamanan makan bagi pelanggan kami.</p>
            </div>
        </div>
    </div>

    <!-- Chef / Kitchen Snippet -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24 mb-10 bg-secondary rounded-3xl overflow-hidden flex flex-col lg:flex-row shadow-2xl">
        <div class="lg:w-1/2 p-12 lg:p-16 flex flex-col justify-center text-white">
            <h2 class="text-cyan-400 font-bold tracking-widest uppercase text-sm mb-2">Dapur Kami</h2>
            <h3 class="text-4xl font-extrabold mb-6">Dedikasi Profesional</h3>
            <p class="text-gray-300 mb-6 leading-relaxed">
                Di belakang setiap sajian di meja Anda, ada sebuah tim yang telah mengorbankan waktu dan keahliannya untuk menyempurnakan resep.
            </p>
            <p class="text-gray-300 leading-relaxed mb-8">
                Tim dapur Gresda Food dipimpin oleh talenta muda yang sangat memperhatikan tingkat kematangan, <i>hygiene</i> komoditas, dan presentasi akhir.
            </p>
            <a href="<?= BASEURL ?>/menu" class="self-start px-8 py-3 bg-white text-secondary rounded-full font-bold hover:bg-gray-100 transition shadow">
                Cicipi Mahakarya Kami
            </a>
        </div>
        <div class="lg:w-1/2 relative min-h-[400px]">
            <img src="<?= BASEURL ?>/images/aesthetic/05.jpg" alt="Dapur Kami" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-secondary via-transparent to-transparent lg:bg-gradient-to-r lg:from-secondary lg:to-transparent"></div>
        </div>
    </div>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
