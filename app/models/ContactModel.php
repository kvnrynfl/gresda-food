<?php

/**
 * Contact Model
 * 
 * Updated for new schema with subject, read tracking
 * Table: tbl_contacts
 */
class ContactModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->query("SELECT * FROM tbl_contacts ORDER BY created_at DESC");
        return $this->resultSet();
    }

    public function getById($id)
    {
        $this->query("SELECT * FROM tbl_contacts WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function create($data)
    {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_contacts (id, name, email, subject, message) 
                       VALUES (:id, :name, :email, :subject, :message)");
        $this->bind(':id', $id);
        $this->bind(':name', $data['name']);
        $this->bind(':email', $data['email']);
        $this->bind(':subject', $data['subject'] ?? null);
        $this->bind(':message', $data['message']);
        return $this->execute();
    }

    public function markRead($id)
    {
        $this->query("UPDATE tbl_contacts SET is_read = 1, read_at = NOW() WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function getUnreadCount()
    {
        $this->query("SELECT COUNT(*) as count FROM tbl_contacts WHERE is_read = 0");
        $result = $this->single();
        return $result['count'] ?? 0;
    }

    public function delete($id)
    {
        $this->query("DELETE FROM tbl_contacts WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
