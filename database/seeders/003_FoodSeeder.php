<?php

/**
 * Food Seeder
 * Creates all menu items from original data, now using category_id FK
 */
return function ($db) {
    // Category ID mapping (slug -> id)
    $cats = [
        'prime-steak' => 'e608880c-c129-46d9-bcad-99ecb038f84c',
        'speciality-steak' => 'f0931810-9e36-4ba0-927d-8d260f6e90ea',
        'western-delight' => 'a4c5e2cd-7640-4b18-9cf5-5e9bcb0c1b47',
        'burger' => 'ad6c9de9-4574-448a-aea8-bed1e2991b56',
        'soup-salad' => 'e32792ae-cf1e-4043-a8cf-b259a4f7a47a',
        'light-meal' => '51b2fdaa-a55a-4748-8c31-73c9d4e7f38f',
        'dessert' => '392e3431-2a6d-49f8-9392-b882b8e247f4',
        'drink' => '04d0e653-8063-4734-9b0c-a958bb106ed6',
    ];

    $foods = [
        // Prime Steak
        ['id'=>'b2527a9c-7407-411d-93d6-3ce36cd41ef2','cat'=>'prime-steak','name'=>'Aussie Lamb Chop','slug'=>'aussie-lamb-chop','price'=>30000,'desc'=>'Grill Imported Australian Lamb Chop Served With Butter On Top, Rosemary, Lemon Wedges, Choices Of Potato, Vegetable, And Sauce. 250GR','img'=>'9362.jpg','weight'=>'250gr'],
        ['id'=>'9bd8a94e-c6c6-44c1-8045-60ff48af7cfa','cat'=>'prime-steak','name'=>'Norwegian Salmon Steak','slug'=>'norwegian-salmon-steak','price'=>35000,'desc'=>'Grilled Imported Norwegian Salmon Served With Butter On Top, Rosemary, Lemon Wedges, Choices Of Potato, Vegetable And White Mushroom Sauce. 200GR','img'=>'1782.jpg','weight'=>'200gr'],
        ['id'=>'48f96f74-8ce0-4b37-8c7f-63d70c5c149e','cat'=>'prime-steak','name'=>'US Short Ribs BBQ','slug'=>'us-short-ribs-bbq','price'=>35000,'desc'=>'Grilled imported US short ribs glazed with our homemade sauce served with choices of potato, vegetable, and Korean barbeque sauce. 300GR','img'=>'4161.jpg','weight'=>'300gr'],
        ['id'=>'ee25bf38-3b0e-4b30-bdb8-987bb5a5e18a','cat'=>'prime-steak','name'=>'Sirloin Meltique Wagyu','slug'=>'sirloin-meltique-wagyu','price'=>40000,'desc'=>'Grilled sirloin meltique wagyu served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR','img'=>'7260.jpg','weight'=>'200gr'],
        ['id'=>'74488fc9-e858-48ba-89a1-d99c0c359ae8','cat'=>'prime-steak','name'=>'Rib Eye Meltique Wagyu','slug'=>'rib-eye-meltique-wagyu','price'=>40000,'desc'=>'Grilled rib eye meltique wagyu served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR','img'=>'480.jpg','weight'=>'200gr'],
        ['id'=>'d48a3b8f-ed7e-4e71-aed6-777d9def9bb9','cat'=>'prime-steak','name'=>'Tenderloin Meltique Wagyu','slug'=>'tenderloin-meltique-wagyu','price'=>45000,'desc'=>'Grilled tenderloin meltique wagyu served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR','img'=>'1733.jpg','weight'=>'200gr'],
        ['id'=>'29d69e58-beb9-4ccf-b6db-5412295d3b2b','cat'=>'prime-steak','name'=>'US Black Angus Sirloin Steak','slug'=>'us-black-angus-sirloin-steak','price'=>45000,'desc'=>'Grilled imported US black angus sirloin served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR','img'=>'3724.jpg','weight'=>'200gr'],
        ['id'=>'668da3b7-8cb5-481f-9912-d5d60102317b','cat'=>'prime-steak','name'=>'US Black Angus Rib Eye Steak','slug'=>'us-black-angus-rib-eye-steak','price'=>50000,'desc'=>'Grilled imported US black angus rib eye served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR','img'=>'3616.jpg','weight'=>'200gr'],
        ['id'=>'c808f4a4-74ee-4e83-8304-df54af4b7f03','cat'=>'prime-steak','name'=>'US Black Angus Tenderloin Steak','slug'=>'us-black-angus-tenderloin-steak','price'=>50000,'desc'=>'Grilled imported US black angus tenderloin served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR','img'=>'6350.jpg','weight'=>'200gr'],
        // Speciality Steak
        ['id'=>'0314f630-d5c5-4188-ad66-106c19134993','cat'=>'speciality-steak','name'=>'Aussie Tenderloin Grain Fed','slug'=>'aussie-tenderloin-grain-fed','price'=>45000,'desc'=>'Grilled imported Aussie tenderloin served with choices of potato, vegetable and sauce. 250GR','img'=>'3761.jpg','weight'=>'250gr'],
        ['id'=>'6e51deab-fa61-4446-bfdd-9fed4e8ba083','cat'=>'speciality-steak','name'=>'Garlic Roasted Chicken','slug'=>'garlic-roasted-chicken','price'=>45000,'desc'=>'It\'s cut in a half 350gr garlic roasted chicken with our signature recipe served with choices of potato, vegetable and sauce.','img'=>'7372.jpg','weight'=>'350gr'],
        ['id'=>'b0f0ee6e-7a1f-4b2f-a27b-d8f29f568066','cat'=>'speciality-steak','name'=>'Aussie Sirloin Cheese Steak','slug'=>'aussie-sirloin-cheese-steak','price'=>60000,'desc'=>'Grilled imported Aussie sirloin 150gr topped with mushroom, smoked beef, mozzarella served with choices of potato, vegetable and sauce.','img'=>'7645.jpg','weight'=>'150gr'],
        ['id'=>'7ff30549-270f-401c-a056-b0c5dd9565e1','cat'=>'speciality-steak','name'=>'American Mix Grill','slug'=>'american-mix-grill','price'=>65000,'desc'=>'Grilled imported Aussie sirloin, boneless chicken breast, beef bratwurst, lamb chop served with choices of potato, vegetable and sauce.','img'=>'586.jpg','weight'=>null],
        ['id'=>'3938b501-926e-4a81-98ba-2cb25e8897dc','cat'=>'speciality-steak','name'=>'Seafood Platter','slug'=>'seafood-platter','price'=>85000,'desc'=>'Grilled lobster, imported Norwegian salmon and dory served with choices of potato, vegetable and white mushroom sauce.','img'=>'900.jpg','weight'=>null],
        ['id'=>'c8894a06-aa70-4371-b618-a863dae7a0dd','cat'=>'speciality-steak','name'=>'Surf & Turf','slug'=>'surf-and-turf','price'=>125000,'desc'=>'Grilled imported Aussie tenderloin 250gr and lobster 300gr served with choices of potato, vegetable and white mushroom sauce.','img'=>'1794.jpg','weight'=>'550gr'],
        ['id'=>'dc8a3e72-2c28-4e6e-8538-68ff07a8450b','cat'=>'speciality-steak','name'=>'Garlic Butter Lobster','slug'=>'garlic-butter-lobster','price'=>110000,'desc'=>'600gr aromatic garlic butter lobster served with choices of potato, vegetable and combine with white mushroom sauce.','img'=>'4468.jpg','weight'=>'600gr'],
        ['id'=>'2644dbff-e402-4f30-883c-5996bac15586','cat'=>'speciality-steak','name'=>'Family BBQ (4 Person)','slug'=>'family-bbq-4-person','price'=>180000,'desc'=>'2 Slices Aussie Sirloin Steak, 2 pcs Dory Crispy, 4 Slices Grilled Chicken, 4 pcs Beef Bratwurst, served with 4 kind of sauce, Choices of Potato, Choices of Vegetable and 4 Iced Lemon Tea.','img'=>'1097.jpg','weight'=>null],
        ['id'=>'e90996e6-3f36-4c8b-a5c0-ffd4edc6c6e5','cat'=>'speciality-steak','name'=>'Meat Lovers Platter (6 Person)','slug'=>'meat-lovers-platter-6-person','price'=>280000,'desc'=>'2 Slices Aussie Tenderloin Steak, 2 Slices Aussie Sirloin Steak, 4 Slices Aussie Patty Steak, 4 pcs Beef Bratwurst served with 3 Kind of sauce, Choices of Potato, Choices of Vegetable and 6 Iced Lemon Tea.','img'=>'4640.jpg','weight'=>null],
        // Western Delight
        ['id'=>'28ef5a23-7918-4b63-a5d8-3e733fee4724','cat'=>'western-delight','name'=>'Beef Pizzaiola','slug'=>'beef-pizzaiola','price'=>40000,'desc'=>'Breaded tenderloin topping mozarella cheese, caramelized onion and smoked beef, served with choices of potato, vegetable and sauce.','img'=>'7290.jpg','weight'=>null],
        ['id'=>'a50f2b5d-564a-4e3f-8f4d-c4878ed975c5','cat'=>'western-delight','name'=>'Beef Cordon Bleu','slug'=>'beef-cordon-bleu','price'=>40000,'desc'=>'Breaded tenderloin filling with mozzarella cheese and smoked beef served with choices of potato, vegetable and sauce.','img'=>'913.jpg','weight'=>null],
        ['id'=>'b3314ff5-f6be-4d1a-8641-229939549355','cat'=>'western-delight','name'=>'Beef Schnitzel','slug'=>'beef-schnitzel','price'=>40000,'desc'=>'Breaded tenderloin, sunny side up, served with choices of potato, vegetable and sauce.','img'=>'8513.jpg','weight'=>null],
        ['id'=>'f6b9d2e8-e581-4aaf-b13f-00a3bcd0360e','cat'=>'western-delight','name'=>'American Fish & Chip','slug'=>'american-fish-and-chip','price'=>50000,'desc'=>'Batter fillet dory crispy topped with mozzarella cheese served with choices of potato, vegetable and tartar sauce.','img'=>'8540.jpg','weight'=>null],
        ['id'=>'3831cba4-6843-4bde-82c5-0ea8bf6bb93b','cat'=>'western-delight','name'=>'John Dory','slug'=>'john-dory','price'=>40000,'desc'=>'Breaded fillet dory 150 gr, served with choices of potato, vegetable and tartar sauce.','img'=>'3717.jpg','weight'=>'150gr'],
        ['id'=>'fb76b51e-a79e-4280-b0ee-d3a1a7b97514','cat'=>'western-delight','name'=>'Chicken Pizzaiola','slug'=>'chicken-pizzaiola','price'=>37000,'desc'=>'Breaded boneless chicken leg topped with mozzarella cheese, caramelized onion and smoked beef served with choices of potato, vegetable and sauce.','img'=>'9348.jpg','weight'=>null],
        ['id'=>'eaeab763-0c5f-4049-ba6c-311b789f2cfd','cat'=>'western-delight','name'=>'Chicken Cordon Bleu','slug'=>'chicken-cordon-bleu','price'=>35000,'desc'=>'Breaded boneless chicken breast filling with mozzarella cheese and smoked beef, served with choices of potato, vegetable and sauce.','img'=>'2497.jpg','weight'=>null],
        ['id'=>'f9441127-234c-45aa-a090-949043e2ab2d','cat'=>'western-delight','name'=>'Fish Me To The Moon','slug'=>'fish-me-to-the-moon','price'=>35000,'desc'=>'Breaded fillet dory filling with mozzarella cheese and smoked beef, served with choices of potato, vegetable and sauce.','img'=>'9026.jpg','weight'=>null],
        ['id'=>'58f0ecaf-a7be-42b8-b803-2c4e135c8aff','cat'=>'western-delight','name'=>'Chicken Maryland','slug'=>'chicken-maryland','price'=>35000,'desc'=>'Breaded boneless chicken leg served with choices of potato, vegetable and sauce.','img'=>'8674.jpg','weight'=>null],
        // Burger
        ['id'=>'0564c435-6030-4578-a454-a44cf25b7a8a','cat'=>'burger','name'=>'Teriyaki Burger','slug'=>'teriyaki-burger','price'=>25000,'desc'=>'Burger bun, chicken teriyaki, vegetable, mayonnaise and caramelized onion served with choices of potato.','img'=>'2699.jpg','weight'=>null],
        ['id'=>'bff6a2c9-36b5-4efa-997b-d449ad876dd5','cat'=>'burger','name'=>'Grill Chicken Burger','slug'=>'grill-chicken-burger','price'=>25000,'desc'=>'Brown burger bun, grilled chicken, American cheese, vegetables, caramelized onion, barbeque sauce, and mayonnaise, served with choices of potato.','img'=>'2672.jpg','weight'=>null],
        ['id'=>'0318a245-3f92-46d0-ba33-a454883c753f','cat'=>'burger','name'=>'Ohio Fish Burger','slug'=>'ohio-fish-burger','price'=>25000,'desc'=>'Burger bun, fillet dory crispy, American cheese, vegetable, caramelized onion, tartar sauce served with choices of potato.','img'=>'3361.jpg','weight'=>null],
        ['id'=>'cf21e4b3-1f1a-4a4d-bc3a-91661e5b9993','cat'=>'burger','name'=>'Old Fashioned Beef Burger','slug'=>'old-fashioned-beef-burger','price'=>30000,'desc'=>'Burger bun, double beef patty, triple American cheese, vegetable, caramelized onion, barbeque sauce and mayonnaise, served with choices of potato.','img'=>'1985.jpg','weight'=>null],
        ['id'=>'830a2929-5809-453d-ab59-b1c0082eb4e8','cat'=>'burger','name'=>'Sloppy Joe Burger','slug'=>'sloppy-joe-burger','price'=>30000,'desc'=>'Burger bun, double beef patty, American cheese, vegetable, caramelized onion, sloppy joe sauce and mayonnaise served with choices of potato.','img'=>'238.jpg','weight'=>null],
        ['id'=>'5bc69968-d0d0-44ff-a7e1-0a8ebce6780e','cat'=>'burger','name'=>'American Burger','slug'=>'american-burger','price'=>30000,'desc'=>'Burger bun, double beef patty, double American cheese, smoked beef, sunny side up, vegetable, barbeque sauce and mayonnaise served with choices of potato.','img'=>'5887.jpg','weight'=>null],
        // Soup & Salad
        ['id'=>'917215df-c523-4f38-9506-c344fc519880','cat'=>'soup-salad','name'=>'Chicken Cream Soup','slug'=>'chicken-cream-soup','price'=>15000,'desc'=>'Cream soup with chicken and corn kernel served with garlic bread.','img'=>'2146.jpg','weight'=>null],
        ['id'=>'fb69b431-c15b-418a-835d-f03dc32c765e','cat'=>'soup-salad','name'=>'Smoked Beef Cream Soup','slug'=>'smoked-beef-cream-soup','price'=>15000,'desc'=>'Cream soup with smoked beef and corn kernel served with garlic bread.','img'=>'5558.jpg','weight'=>null],
        ['id'=>'d06d84dd-cf48-4a40-bcd8-7c4f86b209c0','cat'=>'soup-salad','name'=>'Organic Garden Salad','slug'=>'organic-garden-salad','price'=>15000,'desc'=>'Organic mix lettuce, dressing with balsamic, topped with smoke beef sliced, parmesan cheese served with garlic bread.','img'=>'1763.jpg','weight'=>null],
        ['id'=>'de865092-0b79-4fb1-97bd-a3d26fb1cccd','cat'=>'soup-salad','name'=>'Caesar Chicken Salad','slug'=>'caesar-chicken-salad','price'=>20000,'desc'=>'Organic romaine lettuce, grilled chicken, boiled egg, caesar dressing, parmesan cheese served with garlic bread.','img'=>'4568.jpg','weight'=>null],
        ['id'=>'c7e79187-22de-42a6-98b3-2b8b162e02ad','cat'=>'soup-salad','name'=>'US Prawn Salad','slug'=>'us-prawn-salad','price'=>25000,'desc'=>'Organic lettuce, dressing with balsamic topped with grilled US prawn, parmesan cheese served with garlic bread.','img'=>'6562.jpg','weight'=>null],
        ['id'=>'fbae13af-1ce3-4d5b-80b6-d7543182b4b2','cat'=>'soup-salad','name'=>'Beef Salad','slug'=>'beef-salad','price'=>25000,'desc'=>'Organic lettuce, dressing with balsamic topped with sauted beef, and parmesan cheese and served with garlic bread.','img'=>'7584.jpg','weight'=>null],
        // Light Meal
        ['id'=>'f773f017-bf7b-41eb-992c-d40a17a44905','cat'=>'light-meal','name'=>'French Fries','slug'=>'french-fries','price'=>15000,'desc'=>'Fried potato straight cut 200gr.','img'=>'2960.jpg','weight'=>'200gr'],
        ['id'=>'51e106bf-fc9a-4adf-b93e-67882c1f325f','cat'=>'light-meal','name'=>'Chili Cheese Fries','slug'=>'chili-cheese-fries','price'=>20000,'desc'=>'French fries topped with bolognese sauce and American cheese.','img'=>'4478.jpg','weight'=>null],
        ['id'=>'a8c1c729-a50e-47ee-83f7-802e5fc2db4e','cat'=>'light-meal','name'=>'Chili Cheese Nachos','slug'=>'chili-cheese-nachos','price'=>20000,'desc'=>'Corn tortilla topped with bolognese sauce and American cheese.','img'=>'2860.jpg','weight'=>null],
        ['id'=>'b877ddee-c542-4851-b9d6-fa8036bf9213','cat'=>'light-meal','name'=>'Fish & Chips','slug'=>'fish-and-chips','price'=>23000,'desc'=>'Batter fillet dory crispy served with french fries, lemon wedges and tartar sauce.','img'=>'971.jpg','weight'=>null],
        ['id'=>'b7c4105e-9c76-48cb-aea1-1dd6a772d4dd','cat'=>'light-meal','name'=>'Hot Wings','slug'=>'hot-wings','price'=>23000,'desc'=>'Fried chicken wings served with french fries and Korean barbeque sauce.','img'=>'430.jpg','weight'=>null],
        ['id'=>'98517f40-6853-49d7-aa29-30adfee76bc8','cat'=>'light-meal','name'=>'Sausage & Fries','slug'=>'sausage-and-fries','price'=>25000,'desc'=>'Beef bratwurst served with french fries and barbeque sauce.','img'=>'271.jpg','weight'=>null],
        // Dessert
        ['id'=>'816c0617-1a6f-42e6-85ae-a166d0c5cbbe','cat'=>'dessert','name'=>'Banana Split','slug'=>'banana-split','price'=>15000,'desc'=>'3 scoops ice cream, peach, cavendish topped with whipped cream and granola.','img'=>'2504.jpg','weight'=>null],
        ['id'=>'65d4d1f5-7650-4e3a-b869-c0a17a7b4b30','cat'=>'dessert','name'=>'Brownies Cheezie Sundae','slug'=>'brownies-cheezie-sundae','price'=>15000,'desc'=>'Our homemade cheese brownies served with vanilla ice cream.','img'=>'1877.jpg','weight'=>null],
        ['id'=>'e2dba56d-f311-4cb8-a909-235ad9bcb858','cat'=>'dessert','name'=>'Fruity Granola','slug'=>'fruity-granola','price'=>25000,'desc'=>'Granola, peach, strawberry, cavendish, dragon fruit served with honey and fresh milk.','img'=>'4567.jpg','weight'=>null],
        // Drinks (sample selection)
        ['id'=>'d9b80204-a9a0-42d9-8f89-4d4b27e9b3cc','cat'=>'drink','name'=>'Midnight B2uty','slug'=>'midnight-b2uty','price'=>13000,'desc'=>'Korean squash rasa Lychee & Grape','img'=>'2014.jpg','weight'=>null],
        ['id'=>'7f3b5c6f-3625-49d7-9703-834661b854f3','cat'=>'drink','name'=>'Exotic Kiss','slug'=>'exotic-kiss','price'=>13000,'desc'=>'Korean squash rasa Lime','img'=>'3956.jpg','weight'=>null],
        ['id'=>'c7d57c7c-3def-407f-ad59-86e79f8414d2','cat'=>'drink','name'=>'Blackjack Fire','slug'=>'blackjack-fire','price'=>13000,'desc'=>'Korean squash rasa Bubblegum','img'=>'3556.jpg','weight'=>null],
        ['id'=>'42d134a4-df63-4cf3-bfc7-e5129264914c','cat'=>'drink','name'=>'Inspirit Destiny','slug'=>'inspirit-destiny','price'=>13000,'desc'=>'Korean squash rasa Honeydew & Mango','img'=>'5834.jpg','weight'=>null],
        ['id'=>'7204b608-6904-4467-b4d4-d5aaffc2d40c','cat'=>'drink','name'=>'Boice Intuition','slug'=>'boice-intuition','price'=>13000,'desc'=>'Korean squash rasa Vanila','img'=>'514.jpg','weight'=>null],
        ['id'=>'7e52d786-53d7-4f7e-ba06-5cab8bf15ce7','cat'=>'drink','name'=>'Bulletproof Army','slug'=>'bulletproof-army','price'=>13000,'desc'=>'Korean squash rasa Honeydew & Strawberry','img'=>'6700.jpg','weight'=>null],
        ['id'=>'beca7c23-4910-490a-986b-d00c89a6fe9c','cat'=>'drink','name'=>'Electric f(x)','slug'=>'electric-fx','price'=>13000,'desc'=>'Korean squash rasa Blueberry & Lime','img'=>'4250.jpg','weight'=>null],
        ['id'=>'97009a9f-c7dc-4ba4-8be0-edc7bf5c645b','cat'=>'drink','name'=>'Sone Fantasy','slug'=>'sone-fantasy','price'=>13000,'desc'=>'Korean squash rasa Strawberry','img'=>'6912.jpg','weight'=>null],
        ['id'=>'58d9fc75-1869-4321-8d20-b35b357eb7ca','cat'=>'drink','name'=>'I Got7 Love','slug'=>'i-got7-love','price'=>13000,'desc'=>'Korean squash rasa Lemon & Strawberry','img'=>'8590.jpg','weight'=>null],
        ['id'=>'a0202a01-ec21-415b-8b1f-8a35027cf5c7','cat'=>'drink','name'=>'Hottest Legend','slug'=>'hottest-legend','price'=>13000,'desc'=>'Korean squash rasa Blue Pineapple','img'=>'7951.jpg','weight'=>null],
        ['id'=>'bbab1a38-254d-4f70-99da-6fbc61a02e94','cat'=>'drink','name'=>'Elf Miracle','slug'=>'elf-miracle','price'=>13000,'desc'=>'Korean squash rasa Blueberry','img'=>'6208.jpg','weight'=>null],
        ['id'=>'1c1cbc0f-b67b-424c-834a-6518b0b5684f','cat'=>'drink','name'=>'Shawol Oxygen','slug'=>'shawol-oxygen','price'=>13000,'desc'=>'Korean squash rasa Lychee','img'=>'3693.jpg','weight'=>null],
        ['id'=>'7bc73e94-88ab-43c5-b2a9-78b128093f64','cat'=>'drink','name'=>'Daisy Twinkle','slug'=>'daisy-twinkle','price'=>13000,'desc'=>'Korean squash rasa Raspberry','img'=>'1762.jpg','weight'=>null],
        ['id'=>'d0576d58-b0ce-48ef-a47c-0560105b29dd','cat'=>'drink','name'=>'Lively Vip','slug'=>'lively-vip','price'=>13000,'desc'=>'Korean squash rasa Lemon','img'=>'8277.jpg','weight'=>null],
        ['id'=>'623897e3-e904-4ba6-8806-d8d9967ae2b9','cat'=>'drink','name'=>'Super Starlight','slug'=>'super-starlight','price'=>13000,'desc'=>'Korean squash rasa Grape & Blue Curacao','img'=>'1216.jpg','weight'=>null],
        ['id'=>'9e7bd3fc-7fc0-4ce2-af19-f3213af8ff26','cat'=>'drink','name'=>'Blink on Fire','slug'=>'blink-on-fire','price'=>13000,'desc'=>'Korean squash rasa Strawberry Mocca','img'=>'8704.jpg','weight'=>null],
        ['id'=>'fd122162-2c55-4381-b28b-4967bc8a6cd4','cat'=>'drink','name'=>'Oh My Carat','slug'=>'oh-my-carat','price'=>13000,'desc'=>'Korean squash rasa Cotton Candy','img'=>'6224.jpg','weight'=>null],
        ['id'=>'9626dfbe-88b5-44d6-bbb3-2bfed917bd01','cat'=>'drink','name'=>'Once Likey','slug'=>'once-likey','price'=>13000,'desc'=>'Korean squash rasa Strawberry Lime','img'=>'9211.jpg','weight'=>null],
        ['id'=>'f916ce33-0767-48a2-960e-02ccdcf0c428','cat'=>'drink','name'=>'Baby Aroha','slug'=>'baby-aroha','price'=>13000,'desc'=>'Korean squash rasa Raspberry Lime','img'=>'1092.jpg','weight'=>null],
        ['id'=>'73408225-9ca4-4f9c-8929-0bcb829c03e2','cat'=>'drink','name'=>'Summer Buddy','slug'=>'summer-buddy','price'=>13000,'desc'=>'Korean squash rasa Rose Berry','img'=>'9538.jpg','weight'=>null],
        ['id'=>'e456bede-7480-4efc-84a2-a157ab80d918','cat'=>'drink','name'=>'Wannable Boomerang','slug'=>'wannable-boomerang','price'=>13000,'desc'=>'Korean squash rasa Lemon & Mango','img'=>'2471.jpg','weight'=>null],
        ['id'=>'f48bc1b4-e93a-4017-acc8-414bebb0139f','cat'=>'drink','name'=>'Limitless NCTzen','slug'=>'limitless-nctzen','price'=>13000,'desc'=>'Korean squash rasa Honeydew & Pineapple','img'=>'9912.jpg','weight'=>null],
        ['id'=>'ff3e3a99-5ef3-4be5-967b-a4062ee41f73','cat'=>'drink','name'=>'Ikonic Bling','slug'=>'ikonic-bling','price'=>13000,'desc'=>'Korean squash rasa Fruit Punch','img'=>'2309.jpg','weight'=>null],
    ];

    $count = 0;
    foreach ($foods as $food) {
        $db->query("INSERT INTO tbl_food (id, category_id, name, slug, price, description, image, weight, is_active) 
                     VALUES (:id, :cat_id, :name, :slug, :price, :desc, :img, :weight, 1)");
        $db->bind(':id', $food['id']);
        $db->bind(':cat_id', $cats[$food['cat']]);
        $db->bind(':name', $food['name']);
        $db->bind(':slug', $food['slug']);
        $db->bind(':price', $food['price']);
        $db->bind(':desc', $food['desc']);
        $db->bind(':img', $food['img']);
        $db->bind(':weight', $food['weight']);
        $db->execute();
        $count++;
    }

    echo "    → {$count} food items created\n";
};
