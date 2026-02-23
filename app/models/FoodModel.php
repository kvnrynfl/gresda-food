<?php

class FoodModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function getAll($limitOffset = "") {
        $this->query("SELECT * FROM tbl_food ORDER BY food_id DESC " . $limitOffset);
        return $this->resultSet();
    }

    public function getActive($limitOffset = "") {
        $this->query("SELECT * FROM tbl_food WHERE active = 'Yes' ORDER BY rand() " . $limitOffset);
        return $this->resultSet();
    }

    public function countActive() {
        $this->query("SELECT COUNT(*) as total FROM tbl_food WHERE active = 'Yes'");
        return $this->single()['total'];
    }

    public function getById($id) {
        $this->query("SELECT * FROM tbl_food WHERE food_id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function getByCategory($category_slug) {
        $this->query("SELECT * FROM tbl_food WHERE category = :category AND active='Yes'");
        $this->bind(':category', $category_slug);
        return $this->resultSet();
    }

    public function create($data) {
        $food_id = UUID::v4();
        $this->query("INSERT INTO tbl_food (food_id, category, name, price, description, image_name, active) VALUES (:food_id, :category, :name, :price, :description, :image_name, :active)");
        $this->bind(':food_id', $food_id);
        $this->bind(':category', $data['category']);
        $this->bind(':name', $data['name']);
        $this->bind(':price', $data['price']);
        $this->bind(':description', $data['description']);
        $this->bind(':image_name', $data['image_name']);
        $this->bind(':active', $data['active']);
        return $this->execute();
    }

    public function update($id, $data) {
        $this->query("UPDATE tbl_food SET category = :category, name = :name, price = :price, description = :description, image_name = :image_name, active = :active WHERE food_id = :id");
        $this->bind(':category', $data['category']);
        $this->bind(':name', $data['name']);
        $this->bind(':price', $data['price']);
        $this->bind(':description', $data['description']);
        $this->bind(':image_name', $data['image_name']);
        $this->bind(':active', $data['active']);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_food WHERE food_id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function getTopSelling($limit = 10) {
        $this->query("
            SELECT f.*, COALESCE(SUM(d.qty), 0) as total_sold
            FROM tbl_food f
            LEFT JOIN tbl_detailorder d ON f.food_id = d.food_id
            LEFT JOIN tbl_cart c ON d.order_id = c.order_id AND c.status != 'Cart'
            WHERE f.active = 'Yes'
            GROUP BY f.food_id
            ORDER BY total_sold DESC
            LIMIT :limit
        ");
        $this->bind(':limit', $limit);
        return $this->resultSet();
    }
}
