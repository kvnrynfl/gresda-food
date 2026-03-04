<?php

/**
 * Category Seeder
 * Creates 8 food categories matching original data
 */
return function ($db) {
    $categories = [
        ['id' => 'e608880c-c129-46d9-bcad-99ecb038f84c', 'name' => 'Prime Steak', 'slug' => 'prime-steak', 'icon' => 'fa-drumstick-bite', 'sort_order' => 1],
        ['id' => 'f0931810-9e36-4ba0-927d-8d260f6e90ea', 'name' => 'Speciality Steak', 'slug' => 'speciality-steak', 'icon' => 'fa-fire', 'sort_order' => 2],
        ['id' => 'a4c5e2cd-7640-4b18-9cf5-5e9bcb0c1b47', 'name' => 'Western Delight', 'slug' => 'western-delight', 'icon' => 'fa-utensils', 'sort_order' => 3],
        ['id' => 'ad6c9de9-4574-448a-aea8-bed1e2991b56', 'name' => 'Burger', 'slug' => 'burger', 'icon' => 'fa-hamburger', 'sort_order' => 4],
        ['id' => 'e32792ae-cf1e-4043-a8cf-b259a4f7a47a', 'name' => 'Soup & Salad', 'slug' => 'soup-salad', 'icon' => 'fa-leaf', 'sort_order' => 5],
        ['id' => '51b2fdaa-a55a-4748-8c31-73c9d4e7f38f', 'name' => 'Light Meal', 'slug' => 'light-meal', 'icon' => 'fa-cookie-bite', 'sort_order' => 6],
        ['id' => '392e3431-2a6d-49f8-9392-b882b8e247f4', 'name' => 'Dessert', 'slug' => 'dessert', 'icon' => 'fa-ice-cream', 'sort_order' => 7],
        ['id' => '04d0e653-8063-4734-9b0c-a958bb106ed6', 'name' => 'Drink', 'slug' => 'drink', 'icon' => 'fa-glass-martini-alt', 'sort_order' => 8],
    ];

    foreach ($categories as $cat) {
        $db->query("INSERT INTO tbl_category (id, name, slug, icon, sort_order, is_active) 
                     VALUES (:id, :name, :slug, :icon, :sort, 1)");
        $db->bind(':id', $cat['id']);
        $db->bind(':name', $cat['name']);
        $db->bind(':slug', $cat['slug']);
        $db->bind(':icon', $cat['icon']);
        $db->bind(':sort', $cat['sort_order']);
        $db->execute();
    }

    echo "    → 8 categories created\n";
};
