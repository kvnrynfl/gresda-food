<?php

/**
 * Payment Method Seeder
 * Creates 6 payment methods (3 bank + 3 e-wallet)
 */
return function ($db) {
    $methods = [
        ['id' => 'd5e42f99-b255-4e27-a0f0-6d46dcf6443c', 'name' => 'Bank BCA', 'type' => 'bank_transfer', 'account_number' => '12345678', 'account_name' => 'Gresda Food', 'icon' => 'bca.png', 'sort_order' => 1],
        ['id' => '9b90299b-9490-4170-8d64-1e803d453d00', 'name' => 'Bank BNI', 'type' => 'bank_transfer', 'account_number' => '23456781', 'account_name' => 'Gresda Food', 'icon' => 'bni.png', 'sort_order' => 2],
        ['id' => '192f2844-98c3-4793-9f72-bbfc234f73a7', 'name' => 'Bank BRI', 'type' => 'bank_transfer', 'account_number' => '34567812', 'account_name' => 'Gresda Food', 'icon' => 'bri.png', 'sort_order' => 3],
        ['id' => '44737210-d2b2-47f5-8d06-52d38e850f64', 'name' => 'Dana', 'type' => 'e_wallet', 'account_number' => '45678123', 'account_name' => 'Gresda Food', 'icon' => 'dana.png', 'sort_order' => 4],
        ['id' => '735e367c-cd1b-4884-862d-51519cdeae04', 'name' => 'GoPay', 'type' => 'e_wallet', 'account_number' => '56781234', 'account_name' => 'Gresda Food', 'icon' => 'gopay.png', 'sort_order' => 5],
        ['id' => '81e8a2f7-eb7a-41f4-acd3-f8f4a5e2d685', 'name' => 'ShopeePay', 'type' => 'e_wallet', 'account_number' => '67812345', 'account_name' => 'Gresda Food', 'icon' => 'shopeepay.png', 'sort_order' => 6],
    ];

    foreach ($methods as $m) {
        $db->query("INSERT INTO tbl_payment_methods (id, name, type, account_number, account_name, icon, sort_order, is_active) 
                     VALUES (:id, :name, :type, :acc_num, :acc_name, :icon, :sort, 1)");
        $db->bind(':id', $m['id']);
        $db->bind(':name', $m['name']);
        $db->bind(':type', $m['type']);
        $db->bind(':acc_num', $m['account_number']);
        $db->bind(':acc_name', $m['account_name']);
        $db->bind(':icon', $m['icon']);
        $db->bind(':sort', $m['sort_order']);
        $db->execute();
    }

    echo "    → 6 payment methods created\n";
};
