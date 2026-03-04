<?php

/**
 * User Seeder
 * Creates 1 admin + 4 demo customers with bcrypt passwords
 * Default password for all users: 'password123'
 */
return function ($db) {
    $password = password_hash('password123', PASSWORD_BCRYPT);
    $now = date('Y-m-d H:i:s');

    $users = [
        [
            'id' => 'c6bfd833-8167-44f2-916a-d9f24590099b',
            'full_name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gresdafood.com',
            'phone' => '081234567890',
            'address' => 'Gresda Food HQ, Bandung',
            'role' => 'admin',
            'email_verified_at' => $now,
        ],
        [
            'id' => '1bf85fa8-7c6e-46f5-8e1f-ed186ca8f64b',
            'full_name' => 'Kevin Reynaufal',
            'username' => 'kevinreynaufal',
            'email' => 'kevinreynaufal2004@gmail.com',
            'phone' => '081234567891',
            'address' => 'Komplek Baleendah Permai Blok Z No 5',
            'role' => 'customer',
            'email_verified_at' => $now,
        ],
        [
            'id' => 'b2afcaeb-b6d2-4097-bb45-53007d358366',
            'full_name' => 'Irfan Rizqy',
            'username' => 'irfanrizqy',
            'email' => 'irfanrizqy123@gmail.com',
            'phone' => '081234567892',
            'address' => 'Komplek Baleendah Permai Jalan Padi Endah 5 No 200',
            'role' => 'customer',
            'email_verified_at' => $now,
        ],
        [
            'id' => '2b8a42fb-3dc5-42c0-afb9-9ba56bd9bc99',
            'full_name' => 'Fahri Arsyah',
            'username' => 'fahriarsyah',
            'email' => 'fahriarsyah123@gmail.com',
            'phone' => '081234567893',
            'address' => 'Jl Cibuntu Selatan RT 02 / RW 10',
            'role' => 'customer',
            'email_verified_at' => $now,
        ],
        [
            'id' => 'd817e654-c978-4cd0-a878-6872888472b3',
            'full_name' => 'Naufal Andya',
            'username' => 'naufalandya',
            'email' => 'naufalandya123@gmail.com',
            'phone' => '081234567894',
            'address' => 'JL. Wuluku No 24',
            'role' => 'customer',
            'email_verified_at' => $now,
        ],
    ];

    foreach ($users as $user) {
        $db->query("INSERT INTO tbl_users (id, full_name, username, email, password, phone, address, role, email_verified_at) 
                     VALUES (:id, :full_name, :username, :email, :password, :phone, :address, :role, :verified)");
        $db->bind(':id', $user['id']);
        $db->bind(':full_name', $user['full_name']);
        $db->bind(':username', $user['username']);
        $db->bind(':email', $user['email']);
        $db->bind(':password', $password);
        $db->bind(':phone', $user['phone']);
        $db->bind(':address', $user['address']);
        $db->bind(':role', $user['role']);
        $db->bind(':verified', $user['email_verified_at']);
        $db->execute();
    }

    echo "    → 5 users created (1 admin + 4 customers, password: password123)\n";
};
