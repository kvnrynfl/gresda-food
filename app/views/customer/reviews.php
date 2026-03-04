<?php 
$page_title = "Kirim Ulasan";
$back_link = BASEURL . "/customer/orders";
$hide_card = true;
ob_start(); 
?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8">
        <?php if(!empty($error)): ?>
            <div class="bg-cyan-50 text-primary p-4 rounded-lg mb-6 flex items-center gap-3 animate-pulse">
                <i class="fas fa-exclamation-circle text-xl"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($success)): ?>
            <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-xl"></i> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-col items-center mb-8">
            <div class="w-20 h-20 rounded-full bg-cyan-50 flex items-center justify-center mb-4 text-primary shadow-sm border border-cyan-100">
                <i class="fas fa-hamburger text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center">Bagaimana makanan Anda?</h3>
            <p class="text-gray-500 text-sm text-center">Masukan Anda membantu kami menjadi lebih baik.</p>
        </div>

        <form action="<?= BASEURL ?>/customer/submitReview" method="POST" class="space-y-8 max-w-2xl mx-auto">
            <?= CSRF::getTokenField() ?>
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($_GET['order'] ?? 1) ?>">
            
            <div class="text-center">
                <label class="block text-sm font-bold text-gray-700 mb-4">Penilaian Keseluruhan</label>
                
                <!-- Interactive Star Rating -->
                <div class="flex items-center justify-center flex-row-reverse gap-1 group/rating rating-container" id="star-rating">
                    <?php $currentRating = isset($existing_review['rating']) ? (int)$existing_review['rating'] : 5; ?>
                    
                    <input type="radio" id="star5" name="rating" value="5" class="peer hidden" <?= $currentRating == 5 ? 'checked' : '' ?> />
                    <label for="star5" class="text-4xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 cursor-pointer transition-colors duration-200" title="5 - Sangat Bagus!"><i class="fas fa-star block hover:scale-110 transition-transform"></i></label>
                    
                    <input type="radio" id="star4" name="rating" value="4" class="peer hidden" <?= $currentRating == 4 ? 'checked' : '' ?> />
                    <label for="star4" class="text-4xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 cursor-pointer transition-colors duration-200" title="4 - Sangat Baik"><i class="fas fa-star block hover:scale-110 transition-transform"></i></label>
                    
                    <input type="radio" id="star3" name="rating" value="3" class="peer hidden" <?= $currentRating == 3 ? 'checked' : '' ?> />
                    <label for="star3" class="text-4xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 cursor-pointer transition-colors duration-200" title="3 - Rata-rata"><i class="fas fa-star block hover:scale-110 transition-transform"></i></label>
                    
                    <input type="radio" id="star2" name="rating" value="2" class="peer hidden" <?= $currentRating == 2 ? 'checked' : '' ?> />
                    <label for="star2" class="text-4xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 cursor-pointer transition-colors duration-200" title="2 - Buruk"><i class="fas fa-star block hover:scale-110 transition-transform"></i></label>
                    
                    <input type="radio" id="star1" name="rating" value="1" class="peer hidden" <?= $currentRating == 1 ? 'checked' : '' ?> />
                    <label for="star1" class="text-4xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 cursor-pointer transition-colors duration-200" title="1 - Sangat Buruk"><i class="fas fa-star block hover:scale-110 transition-transform"></i></label>
                </div>
                <!-- Dynamic text to show what they rated -->
                <p class="text-primary font-bold mt-3 h-6" id="rating-text">5 - Sangat Bagus!</p>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pikiran Anda (Opsional)</label>
                <textarea name="message" rows="5" placeholder="Beri tahu kami apa yang Anda sukai, hidangan terfavorit Anda, atau apa yang bisa kami tingkatkan..." class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white hover:bg-white transition duration-300 text-gray-800 placeholder-gray-400"><?= htmlspecialchars($existing_review['message'] ?? '') ?></textarea>
            </div>
            
            <button type="submit" class="w-full <?= isset($existing_review) ? 'bg-orange-500 hover:bg-orange-600 shadow-orange-500/30' : 'bg-primary hover:bg-cyan-700 shadow-cyan-500/30' ?> text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-transform hover:-translate-y-1 flex items-center justify-center gap-2 text-lg">
                <i class="fas <?= isset($existing_review) ? 'fa-edit' : 'fa-paper-plane' ?>"></i>
                <?= isset($existing_review) ? 'Perbarui Ulasan' : 'Kirim Ulasan' ?>
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('input[name="rating"]');
    const ratingText = document.getElementById('rating-text');
    
    // Default text maps tied to values
    const textMap = {
        '5': '5 - Sangat Bagus!',
        '4': '4 - Sangat Baik',
        '3': '3 - Rata-rata',
        '2': '2 - Buruk',
        '1': '1 - Sangat Buruk'
    };

    // Find currently checked item
    let currentChecked = document.querySelector('input[name="rating"]:checked');
    if(currentChecked) {
        ratingText.textContent = textMap[currentChecked.value];
    }

    const labels = document.querySelectorAll('.rating-container label');

    // Handle Hover Effects
    labels.forEach(label => {
        label.addEventListener('mouseenter', function() {
            const inputId = this.getAttribute('for');
            const inputVal = document.getElementById(inputId).value;
            ratingText.textContent = textMap[inputVal];
        });

        label.addEventListener('mouseleave', function() {
            // Revert to checked value
            const checkedInput = document.querySelector('input[name="rating"]:checked');
            if(checkedInput) {
                ratingText.textContent = textMap[checkedInput.value];
            } else {
                ratingText.textContent = 'Pilih Penilaian';
            }
        });
    });

    // Handle Click Effect (actually handled implicitly by radio change, but let's be sure text updates)
    starInputs.forEach(input => {
        input.addEventListener('change', function() {
            ratingText.textContent = textMap[this.value];
            // Add a little pop animation to the text
            ratingText.classList.add('scale-110');
            setTimeout(() => ratingText.classList.remove('scale-110'), 200);
        });
    });
});
</script>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>

