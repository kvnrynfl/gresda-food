<?php

class ContactModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->query("SELECT * FROM tbl_contact ORDER BY id DESC");
        return $this->resultSet();
    }

    public function create($data) {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_contact (id, customer_name, customer_email, customer_message) VALUES (:id, :name, :email, :message)");
        $this->bind(':id', $id);
        $this->bind(':name', $data['name']);
        $this->bind(':email', $data['email']);
        $this->bind(':message', $data['message']);
        return $this->execute();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_contact WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
