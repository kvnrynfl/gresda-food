<?php

class ReviewModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function getActive() {
        $this->query("SELECT r.*, u.username, u.img_user FROM tbl_review r JOIN tbl_users u ON r.user_id = u.id WHERE r.active = 'Yes' ORDER BY rand()");
        return $this->resultSet();
    }

    public function getAll() {
        $this->query("SELECT r.*, u.username FROM tbl_review r JOIN tbl_users u ON r.user_id = u.id ORDER BY r.id DESC");
        return $this->resultSet();
    }

    public function create($data) {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_review (id, order_id, user_id, rating, message, active) VALUES (:id, :order_id, :user_id, :rating, :message, :active)");
        $this->bind(':id', $id);
        $this->bind(':order_id', $data['order_id']);
        $this->bind(':user_id', $data['user_id']);
        $this->bind(':rating', $data['rating']);
        $this->bind(':message', $data['message']);
        $this->bind(':active', $data['active'] ?? 'No'); // Pending initially usually, but legacy sets to Yes immediately
        return $this->execute();
    }

    public function updateStatus($id, $active_status) {
        $this->query("UPDATE tbl_review SET active = :active WHERE id = :id");
        $this->bind(':active', $active_status);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_review WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
