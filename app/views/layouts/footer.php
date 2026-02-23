</main> <!-- End Main Content Wrapper -->

    <!-- Footer -->
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
                    <li><a href="<?= BASEURL ?>/about" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right text-xs mr-2"></i>Tentang Kami</a></li>
                    <li><a href="<?= BASEURL ?>/menu" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right text-xs mr-2"></i>Menu Makanan</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4 border-b border-gray-600 pb-2">Hubungi Kami</h4>
                <ul class="space-y-3 text-gray-400">
                    <li class="flex items-start gap-3"><i class="fas fa-map-marker-alt mt-1"></i> Rancaekek, Kab. Bandung, Jawa Barat</li>
                    <li class="flex items-center gap-3"><i class="fas fa-phone"></i> +62 821-2708-3486</li>
                    <li class="flex items-center gap-3"><i class="fas fa-envelope"></i> gresda_food@gmail.com</li>
                </ul>
                <div class="flex gap-4 mt-6">
                    <a href="#" class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-facebook-f text-white"></i></a>
                    <a href="#" class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-instagram text-white"></i></a>
                    <a href="#" class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition"><i class="fab fa-whatsapp text-white"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center text-gray-500 mt-12 pt-6 border-t border-gray-700 text-sm">
            &copy; <?= date('Y') ?> Gresda Food & Beverage. Hak cipta dilindungi undang-undang. Dirancang untuk V2 MVC.
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Place global javascript here if needed
        const baseUrl = '<?= BASEURL ?>';
    </script>
</body>
</html>
