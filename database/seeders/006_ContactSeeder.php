<?php

/**
 * Contact Seeder
 * Creates 1 demo contact message
 */
return function ($db) {
    $id = UUID::v4();
    $db->query("INSERT INTO tbl_contacts (id, name, email, subject, message) 
                 VALUES (:id, :name, :email, :subject, :message)");
    $db->bind(':id', $id);
    $db->bind(':name', 'Kevin Reynaufal');
    $db->bind(':email', 'kevinreynaufal2004@gmail.com');
    $db->bind(':subject', 'Pertanyaan tentang menu');
    $db->bind(':message', 'Hallo, saya ingin bertanya tentang menu yang tersedia. Apakah bisa request menu khusus untuk acara ulang tahun?');
    $db->execute();

    echo "    → 1 contact message created\n";
};
