<?php

class AdminModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_admin (id, full_name, username, password) VALUES (:id, :full_name, :username, :password)");
        $this->bind(':id', $id);
        $this->bind(':full_name', $data['full_name']);
        $this->bind(':username', $data['username']);
        $this->bind(':password', $data['password']); // Expected to be Bcrypt hashed already
        
        return $this->execute();
    }

    public function findAdminByUsername($username) {
        $this->query("SELECT * FROM tbl_admin WHERE username = :username");
        $this->bind(':username', $username);
        return $this->single();
    }

    public function updatePassword($id, $newPassword) {
        $this->query("UPDATE tbl_admin SET password = :password WHERE id = :id");
        $this->bind(':password', $newPassword);
        $this->bind(':id', $id);
        return $this->execute();
    }
    
    public function getAll() {
        $this->query("SELECT * FROM tbl_admin ORDER BY id ASC");
        return $this->resultSet();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_admin WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
