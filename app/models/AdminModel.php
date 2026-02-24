<?php

class AdminModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_users (id, full_name, username, password, role) VALUES (:id, :full_name, :username, :password, 'admin')");
        $this->bind(':id', $id);
        $this->bind(':full_name', $data['full_name']);
        $this->bind(':username', $data['username']);
        $this->bind(':password', $data['password']); // Expected to be Bcrypt hashed already
        
        return $this->execute();
    }

    public function findAdminByUsername($username) {
        $this->query("SELECT * FROM tbl_users WHERE username = :username AND role = 'admin'");
        $this->bind(':username', $username);
        return $this->single();
    }

    public function updatePassword($id, $newPassword) {
        $this->query("UPDATE tbl_users SET password = :password WHERE id = :id AND role = 'admin'");
        $this->bind(':password', $newPassword);
        $this->bind(':id', $id);
        return $this->execute();
    }
    
    public function updateProfile($id, $data) {
        $this->query("UPDATE tbl_users SET full_name = :full_name, username = :username WHERE id = :id AND role = 'admin'");
        $this->bind(':full_name', $data['full_name']);
        $this->bind(':username', $data['username']);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function getById($id) {
        $this->query("SELECT * FROM tbl_users WHERE id = :id AND role = 'admin'");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function getAll() {
        $this->query("SELECT * FROM tbl_users WHERE role = 'admin' ORDER BY id ASC");
        return $this->resultSet();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_users WHERE id = :id AND role = 'admin'");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
