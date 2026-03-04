<?php

/**
 * Order Seeder
 * Creates 4 demo orders with details and payment confirmations
 */
return function ($db) {
    $orders = [
        [
            'id' => 'c4d89855-e840-4bc5-bfb2-51054adf131f',
            'order_number' => 'GF-20211011-0001',
            'user_id' => '1bf85fa8-7c6e-46f5-8e1f-ed186ca8f64b',
            'status' => 'finished',
            'subtotal' => 330000.00,
            'tax_amount' => 33000.00,
            'shipping_cost' => 15000.00,
            'grand_total' => 378000.00,
            'shipping_address' => 'Komplek Baleendah Permai Blok Z No 5',
            'ordered_at' => '2021-10-11 13:54:52',
            'paid_at' => '2021-10-11 13:56:08',
            'finished_at' => '2021-10-11 18:00:00',
            'details' => [
                ['food_id' => 'c808f4a4-74ee-4e83-8304-df54af4b7f03', 'food_name' => 'US Black Angus Tenderloin Steak', 'qty' => 1, 'unit_price' => 50000.00],
                ['food_id' => 'e90996e6-3f36-4c8b-a5c0-ffd4edc6c6e5', 'food_name' => 'Meat Lovers Platter (6 Person)', 'qty' => 1, 'unit_price' => 280000.00],
            ],
            'payment' => [
                'payment_method_id' => 'd5e42f99-b255-4e27-a0f0-6d46dcf6443c',
                'sender_name' => 'Kevin Reynaufal',
                'amount' => 378000.00,
                'proof_image' => '4196.png',
                'payment_date' => '2021-10-11',
                'status' => 'verified',
            ],
        ],
        [
            'id' => '30bb2c37-a863-41e6-8cc4-272506f88be3',
            'order_number' => 'GF-20211011-0002',
            'user_id' => 'b2afcaeb-b6d2-4097-bb45-53007d358366',
            'status' => 'finished',
            'subtotal' => 170000.00,
            'tax_amount' => 17000.00,
            'shipping_cost' => 15000.00,
            'grand_total' => 202000.00,
            'shipping_address' => 'Komplek Baleendah Permai Jalan Padi Endah 5 No 200 RT 03/RW 25',
            'ordered_at' => '2021-10-11 14:32:06',
            'paid_at' => '2021-10-11 14:34:22',
            'finished_at' => '2021-10-11 19:00:00',
            'details' => [
                ['food_id' => 'dc8a3e72-2c28-4e6e-8538-68ff07a8450b', 'food_name' => 'Garlic Butter Lobster', 'qty' => 1, 'unit_price' => 110000.00],
                ['food_id' => 'b0f0ee6e-7a1f-4b2f-a27b-d8f29f568066', 'food_name' => 'Aussie Sirloin Cheese Steak', 'qty' => 1, 'unit_price' => 60000.00],
            ],
            'payment' => [
                'payment_method_id' => '9b90299b-9490-4170-8d64-1e803d453d00',
                'sender_name' => 'Irfan Rizky',
                'amount' => 202000.00,
                'proof_image' => '3095.png',
                'payment_date' => '2021-10-11',
                'status' => 'verified',
            ],
        ],
        [
            'id' => '3655f9cc-3fd4-4be1-9078-c9f51b05fd41',
            'order_number' => 'GF-20211011-0003',
            'user_id' => '2b8a42fb-3dc5-42c0-afb9-9ba56bd9bc99',
            'status' => 'finished',
            'subtotal' => 80000.00,
            'tax_amount' => 8000.00,
            'shipping_cost' => 15000.00,
            'grand_total' => 103000.00,
            'shipping_address' => 'Jl Cibuntu Selatan RT 02 / RW 10',
            'ordered_at' => '2021-10-11 14:40:32',
            'paid_at' => '2021-10-11 14:41:51',
            'finished_at' => '2021-10-11 19:30:00',
            'details' => [
                ['food_id' => '9bd8a94e-c6c6-44c1-8045-60ff48af7cfa', 'food_name' => 'Norwegian Salmon Steak', 'qty' => 1, 'unit_price' => 35000.00],
                ['food_id' => '6e51deab-fa61-4446-bfdd-9fed4e8ba083', 'food_name' => 'Garlic Roasted Chicken', 'qty' => 1, 'unit_price' => 45000.00],
            ],
            'payment' => [
                'payment_method_id' => '192f2844-98c3-4793-9f72-bbfc234f73a7',
                'sender_name' => 'Fahri Arsyah',
                'amount' => 103000.00,
                'proof_image' => '6399.png',
                'payment_date' => '2021-10-11',
                'status' => 'verified',
            ],
        ],
        [
            'id' => 'd6eb8d5d-d6d1-47b7-a637-16fe987ed232',
            'order_number' => 'GF-20211011-0004',
            'user_id' => 'd817e654-c978-4cd0-a878-6872888472b3',
            'status' => 'finished',
            'subtotal' => 75000.00,
            'tax_amount' => 7500.00,
            'shipping_cost' => 15000.00,
            'grand_total' => 97500.00,
            'shipping_address' => 'JL. Wuluku No 24',
            'ordered_at' => '2021-10-11 15:15:53',
            'paid_at' => '2021-10-11 15:17:07',
            'finished_at' => '2021-10-11 20:00:00',
            'details' => [
                ['food_id' => '48f96f74-8ce0-4b37-8c7f-63d70c5c149e', 'food_name' => 'US Short Ribs BBQ', 'qty' => 1, 'unit_price' => 35000.00],
                ['food_id' => '74488fc9-e858-48ba-89a1-d99c0c359ae8', 'food_name' => 'Rib Eye Meltique Wagyu', 'qty' => 1, 'unit_price' => 40000.00],
            ],
            'payment' => [
                'payment_method_id' => '44737210-d2b2-47f5-8d06-52d38e850f64',
                'sender_name' => 'Naufal Andya',
                'amount' => 97500.00,
                'proof_image' => '3038.png',
                'payment_date' => '2021-10-11',
                'status' => 'verified',
            ],
        ],
    ];

    foreach ($orders as $order) {
        // Insert order
        $db->query("INSERT INTO tbl_orders (id, order_number, user_id, status, subtotal, tax_amount, shipping_cost, grand_total, shipping_address, ordered_at, paid_at, finished_at) 
                     VALUES (:id, :order_num, :user_id, :status, :subtotal, :tax, :shipping, :grand, :address, :ordered, :paid, :finished)");
        $db->bind(':id', $order['id']);
        $db->bind(':order_num', $order['order_number']);
        $db->bind(':user_id', $order['user_id']);
        $db->bind(':status', $order['status']);
        $db->bind(':subtotal', $order['subtotal']);
        $db->bind(':tax', $order['tax_amount']);
        $db->bind(':shipping', $order['shipping_cost']);
        $db->bind(':grand', $order['grand_total']);
        $db->bind(':address', $order['shipping_address']);
        $db->bind(':ordered', $order['ordered_at']);
        $db->bind(':paid', $order['paid_at']);
        $db->bind(':finished', $order['finished_at']);
        $db->execute();

        // Insert order details
        foreach ($order['details'] as $detail) {
            $detailId = UUID::v4();
            $subtotal = $detail['qty'] * $detail['unit_price'];
            $db->query("INSERT INTO tbl_order_details (id, order_id, food_id, food_name, qty, unit_price, subtotal) 
                         VALUES (:id, :order_id, :food_id, :food_name, :qty, :price, :subtotal)");
            $db->bind(':id', $detailId);
            $db->bind(':order_id', $order['id']);
            $db->bind(':food_id', $detail['food_id']);
            $db->bind(':food_name', $detail['food_name']);
            $db->bind(':qty', $detail['qty']);
            $db->bind(':price', $detail['unit_price']);
            $db->bind(':subtotal', $subtotal);
            $db->execute();
        }

        // Insert payment confirmation
        $pcId = UUID::v4();
        $pay = $order['payment'];
        $db->query("INSERT INTO tbl_payment_confirmations (id, order_id, user_id, payment_method_id, sender_name, amount, proof_image, payment_date, status, verified_at) 
                     VALUES (:id, :order_id, :user_id, :pm_id, :sender, :amount, :proof, :pay_date, :status, NOW())");
        $db->bind(':id', $pcId);
        $db->bind(':order_id', $order['id']);
        $db->bind(':user_id', $order['user_id']);
        $db->bind(':pm_id', $pay['payment_method_id']);
        $db->bind(':sender', $pay['sender_name']);
        $db->bind(':amount', $pay['amount']);
        $db->bind(':proof', $pay['proof_image']);
        $db->bind(':pay_date', $pay['payment_date']);
        $db->bind(':status', $pay['status']);
        $db->execute();
    }

    echo "    → 4 orders with details and payment confirmations created\n";
};
