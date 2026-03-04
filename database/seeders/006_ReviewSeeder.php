<?php

/**
 * Review Seeder
 * Creates 4 demo customer reviews
 */
return function ($db) {
    $reviews = [
        [
            'user_id' => '1bf85fa8-7c6e-46f5-8e1f-ed186ca8f64b',
            'order_id' => 'c4d89855-e840-4bc5-bfb2-51054adf131f',
            'rating' => 5,
            'message' => 'Waktu datang kesini udah langsung di sambut pelayan yang ramah, trus hidangan makananya juga enak, ditambah suasana dan pemandangan yang indah, Serasa makan di restoran mahal...',
            'status' => 'approved',
        ],
        [
            'user_id' => 'b2afcaeb-b6d2-4097-bb45-53007d358366',
            'order_id' => '30bb2c37-a863-41e6-8cc4-272506f88be3',
            'rating' => 5,
            'message' => 'Pertama diajakin sama pacar kesini kirain menu nya bakal mahal karena vibes tempatnya yang classy banget, ehh ternyata menu nya murah murah dan enak. Pokoknya recomended banget inimah.',
            'status' => 'approved',
        ],
        [
            'user_id' => '2b8a42fb-3dc5-42c0-afb9-9ba56bd9bc99',
            'order_id' => '3655f9cc-3fd4-4be1-9078-c9f51b05fd41',
            'rating' => 5,
            'message' => 'Awalnya saya ragu sih karena ini rumah makan yang bisa di bilang high, setelah saya melihat menu ternyata harganya sangat murah sekali dan makanan nya pun enak. Highly recommended!',
            'status' => 'approved',
        ],
        [
            'user_id' => 'd817e654-c978-4cd0-a878-6872888472b3',
            'order_id' => 'd6eb8d5d-d6d1-47b7-a637-16fe987ed232',
            'rating' => 4,
            'message' => 'Pelayanannya cukup cepat tidak membuat kita menunggu terlalu lama, dan untuk makanan disini cukup enak hanya saja kurang banyak karena saya anak kost :)',
            'status' => 'approved',
        ],
    ];

    foreach ($reviews as $review) {
        $id = UUID::v4();
        $db->query("INSERT INTO tbl_reviews (id, user_id, order_id, rating, message, status, approved_at) 
                     VALUES (:id, :user_id, :order_id, :rating, :message, :status, NOW())");
        $db->bind(':id', $id);
        $db->bind(':user_id', $review['user_id']);
        $db->bind(':order_id', $review['order_id']);
        $db->bind(':rating', $review['rating']);
        $db->bind(':message', $review['message']);
        $db->bind(':status', $review['status']);
        $db->execute();
    }

    echo "    → 4 reviews created\n";
};
