<?php

class UserModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_users (id, full_name, username, email, password) VALUES (:id, :full_name, :username, :email, :password)");
        
        $this->bind(':id', $id);
        $this->bind(':full_name', $data['full_name']);
        $this->bind(':username', $data['username']);
        $this->bind(':email', $data['email']);
        $this->bind(':password', $data['password']); // Expected to be Bcrypt hashed already
        
        return $this->execute();
    }

    public function findUserByEmail($email) {
        $this->query("SELECT * FROM tbl_users WHERE email = :email");
        $this->bind(':email', $email);
        return $this->single();
    }

    public function updatePassword($id, $newPassword) {
        $this->query("UPDATE tbl_users SET password = :password WHERE id = :id");
        $this->bind(':password', $newPassword);
        $this->bind(':id', $id);
        return $this->execute();
    }
    
    public function updateProfile($id, $data) {
        if(isset($data['img_user'])) {
            $this->query("UPDATE tbl_users SET full_name = :full_name, username = :username, img_user = :img_user WHERE id = :id");
            $this->bind(':img_user', $data['img_user']);
        } else {
            $this->query("UPDATE tbl_users SET full_name = :full_name, username = :username WHERE id = :id");
        }
        $this->bind(':full_name', $data['full_name']);
        $this->bind(':username', $data['username']);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function getAll() {
        $this->query("SELECT * FROM tbl_users ORDER BY id DESC");
        return $this->resultSet();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_users WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
