<?php

/**
 * Review Model
 * 
 * Updated for new schema with ENUM status, admin_reply, title
 * Table: tbl_reviews
 */
class ReviewModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getApproved()
    {
        $this->query("
            SELECT r.*, u.username, u.full_name, u.img_user 
            FROM tbl_reviews r 
            JOIN tbl_users u ON r.user_id = u.id 
            WHERE r.status = 'approved' 
            ORDER BY r.created_at DESC
        ");
        return $this->resultSet();
    }

    public function getAll()
    {
        $this->query("
            SELECT r.*, u.username, u.full_name 
            FROM tbl_reviews r 
            JOIN tbl_users u ON r.user_id = u.id 
            ORDER BY r.created_at DESC
        ");
        return $this->resultSet();
    }

    public function getById($id)
    {
        $this->query("
            SELECT r.*, u.username, u.full_name, u.img_user 
            FROM tbl_reviews r 
            JOIN tbl_users u ON r.user_id = u.id 
            WHERE r.id = :id
        ");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function getByUserId($userId)
    {
        $this->query("SELECT * FROM tbl_reviews WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
        $this->bind(':user_id', $userId);
        return $this->single();
    }

    public function create($data)
    {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_reviews (id, user_id, order_id, rating, title, message, status) 
                       VALUES (:id, :user_id, :order_id, :rating, :title, :message, :status)");
        $this->bind(':id', $id);
        $this->bind(':user_id', $data['user_id']);
        $this->bind(':order_id', $data['order_id']);
        $this->bind(':rating', $data['rating']);
        $this->bind(':title', $data['title'] ?? null);
        $this->bind(':message', $data['message']);
        $this->bind(':status', $data['status'] ?? 'pending');
        return $this->execute();
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE tbl_reviews SET status = :status";
        if ($status === 'approved') {
            $sql .= ", approved_at = NOW()";
        }
        $sql .= " WHERE id = :id";

        $this->query($sql);
        $this->bind(':status', $status);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function addAdminReply($id, $reply)
    {
        $this->query("UPDATE tbl_reviews SET admin_reply = :reply WHERE id = :id");
        $this->bind(':reply', $reply);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function update($id, $data)
    {
        $this->query("UPDATE tbl_reviews SET rating = :rating, title = :title, message = :message, status = 'pending' WHERE id = :id");
        $this->bind(':rating', $data['rating']);
        $this->bind(':title', $data['title'] ?? null);
        $this->bind(':message', $data['message']);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function delete($id)
    {
        $this->query("DELETE FROM tbl_reviews WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Get average rating 
     */
    public function getAverageRating()
    {
        $this->query("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM tbl_reviews WHERE status = 'approved'");
        return $this->single();
    }
}
