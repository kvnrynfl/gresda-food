<footer class="bg-secondary text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 select-none md:grid-cols-3 gap-8">
        <!-- Brand -->
        <div>
            <h3 class="mb-4">
                <img src="<?= BASEURL ?>/images/logo/LogoGresdaFoodBeverage.jpg" alt="Logo" class="h-10 w-auto object-contain"> 
            </h3>
            <p class="text-gray-400">Menyajikan Steak Premium & Sajian Barat terbaik dengan rasa luar biasa sejak 2021.</p>
        </div>
        
        <!-- Quick Links -->
        <div>
            <h4 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2">Tautan Cepat</h4>
            <ul class="space-y-2">
                <li><a href="<?= BASEURL ?>/" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right text-xs mr-2"></i>Beranda</a></li>
                <li><a href="<?= BASEURL ?>/menu" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right text-xs mr-2"></i>Menu Makanan</a></li>
                <li><a href="<?= BASEURL ?>/legal/terms" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right text-xs mr-2"></i>Syarat & Ketentuan</a></li>
                <li><a href="<?= BASEURL ?>/legal/privacy" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right text-xs mr-2"></i>Kebijakan Privasi</a></li>
            </ul>
        </div>
        
        <!-- Contact Info -->
        <div>
            <h4 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2">Hubungi Kami</h4>
            <ul class="space-y-3 text-gray-400">
                <li class="flex items-start gap-3"><i class="fas fa-map-marker-alt mt-1"></i> Rancaekek, Kab. Bandung, Jawa Barat</li>
                <li class="flex items-center gap-3"><i class="fas fa-phone"></i> +62 821-2708-3486</li>
                <li class="flex items-center gap-3"><i class="fas fa-envelope"></i>support@gresdafood.com</li>
            </ul>
            <div class="flex gap-4 mt-6">
                <a href="#" class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-facebook-f text-white"></i></a>
                <a href="#" class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-instagram text-white"></i></a>
                <a href="#" class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-whatsapp text-white"></i></a>
            </div>
        </div>
    </div>
    <div class="text-center text-gray-500 mt-12 pt-6 border-t border-gray-700 text-sm">
        &copy; <?= date('Y') ?> Gresda Food & Beverage. Hak cipta dilindungi undang-undang.
    </div>
</footer>

<!-- WhatsApp FAB -->
<a href="https://wa.me/6281234567890" target="_blank" class="fixed bottom-24 right-8 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 hover:-translate-y-1 transition-all duration-300 group z-40" aria-label="Chat WhatsApp">
    <i class="fab fa-whatsapp text-3xl"></i>
    <span class="absolute right-16 bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-md">Hubungi Kami</span>
</a>

<!-- Back to Top Button -->
<button id="back-to-top" class="fixed bottom-8 right-8 bg-primary text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center text-xl hover:bg-cyan-700 hover:-translate-y-1 transition-all duration-300 z-40 opacity-0 pointer-events-none focus:outline-none" aria-label="Back to Top">
    <i class="fas fa-arrow-up"></i>
</button>

<script>

    // Back to top functionality
    document.addEventListener('DOMContentLoaded', () => {
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                    backToTopBtn.classList.add('opacity-100');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
                    backToTopBtn.classList.remove('opacity-100');
                }
            });

            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>

<!-- AOS Animation Library Initialization -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    });
</script>
