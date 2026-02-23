<?php

class CategoryModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->query("SELECT * FROM tbl_category");
        return $this->resultSet();
    }

    public function getActive() {
        $this->query("SELECT * FROM tbl_category WHERE active = 'Yes'");
        return $this->resultSet();
    }

    public function getById($id) {
        $this->query("SELECT * FROM tbl_category WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function getByCategorySlug($category) {
        $this->query("SELECT * FROM tbl_category WHERE category = :category");
        $this->bind(':category', $category);
        return $this->single();
    }

    public function create($data) {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_category (id, name, category, active) VALUES (:id, :name, :category, :active)");
        $this->bind(':id', $id);
        $this->bind(':name', $data['name']);
        $this->bind(':category', $data['category']);
        $this->bind(':active', $data['active']);
        return $this->execute();
    }

    public function update($id, $data) {
        $this->query("UPDATE tbl_category SET name = :name, category = :category, active = :active WHERE id = :id");
        $this->bind(':name', $data['name']);
        $this->bind(':category', $data['category']);
        $this->bind(':active', $data['active']);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_category WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
