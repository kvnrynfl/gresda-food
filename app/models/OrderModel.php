<?php

class OrderModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function getAllOrders() {
        // Admin gets all orders
        $this->query("SELECT o.*, u.username, u.email FROM tbl_orders o LEFT JOIN tbl_users u ON o.user_id = u.id ORDER BY o.created_at DESC");
        return $this->resultSet();
    }

    public function getOrdersByUser($user_id) {
        $this->query("SELECT * FROM tbl_orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->bind(':user_id', $user_id);
        return $this->resultSet();
    }

    // Cart is now its own table: id, user_id, food_id, qty
    public function getCartItemsByUser($user_id) {
        $this->query("SELECT c.*, c.id as detail_id, f.name, f.price, f.image_name 
                      FROM tbl_cart c 
                      JOIN tbl_food f ON c.food_id = f.food_id 
                      WHERE c.user_id = :user_id");
        $this->bind(':user_id', $user_id);
        return $this->resultSet();
    }

    public function addToCart($user_id, $food_id, $qty = 1) {
        $this->query("SELECT * FROM tbl_cart WHERE user_id = :user_id AND food_id = :food_id");
        $this->bind(':user_id', $user_id);
        $this->bind(':food_id', $food_id);
        $existing = $this->single();

        if ($existing) {
            $this->query("UPDATE tbl_cart SET qty = qty + :qty WHERE id = :id");
            $this->bind(':qty', $qty);
            $this->bind(':id', $existing['id']);
            return $this->execute();
        } else {
            $id = UUID::v4();
            $this->query("INSERT INTO tbl_cart (id, user_id, food_id, qty) VALUES (:id, :user_id, :food_id, :qty)");
            $this->bind(':id', $id);
            $this->bind(':user_id', $user_id);
            $this->bind(':food_id', $food_id);
            $this->bind(':qty', $qty);
            return $this->execute();
        }
    }

    public function updateCartQty($detail_id, $qty) {
        $this->query("UPDATE tbl_cart SET qty = :qty WHERE id = :id");
        $this->bind(':qty', $qty);
        $this->bind(':id', $detail_id);
        return $this->execute();
    }

    public function removeCartItem($detail_id) {
        $this->query("DELETE FROM tbl_cart WHERE id = :id");
        $this->bind(':id', $detail_id);
        return $this->execute();
    }

    public function getCartItemById($detail_id) {
        $this->query("SELECT c.*, c.id as detail_id, f.price FROM tbl_cart c JOIN tbl_food f ON c.food_id = f.food_id WHERE c.id = :id");
        $this->bind(':id', $detail_id);
        return $this->single();
    }

    // Checkout: create order & move items
    public function createOrder($order_id, $user_id, $total, $status = 'Pending') {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_orders (id, order_id, user_id, status, total) VALUES (:id, :order_id, :user_id, :status, :total)");
        $this->bind(':id', $id);
        $this->bind(':order_id', $order_id);
        $this->bind(':user_id', $user_id);
        $this->bind(':status', $status);
        $this->bind(':total', $total);
        return $this->execute();
    }

    public function addDetailItem($order_id, $food_id, $qty, $price) {
        $detail_id = UUID::v4();
        $this->query("INSERT INTO tbl_order_details (detail_id, order_id, food_id, qty, price_at_time) VALUES (:detail_id, :order_id, :food_id, :qty, :price)");
        $this->bind(':detail_id', $detail_id);
        $this->bind(':order_id', $order_id);
        $this->bind(':food_id', $food_id);
        $this->bind(':qty', $qty);
        $this->bind(':price', $price);
        return $this->execute();
    }

    public function getOrderDetails($order_id) {
        $this->query("SELECT d.*, f.name, f.price, f.image_name 
                      FROM tbl_order_details d 
                      JOIN tbl_food f ON d.food_id = f.food_id 
                      WHERE d.order_id = :order_id");
        $this->bind(':order_id', $order_id);
        return $this->resultSet();
    }

    public function getPaymentDetails($order_id) {
        $this->query("SELECT * FROM tbl_confirmorder WHERE order_id = :order_id");
        $this->bind(':order_id', $order_id);
        return $this->single();
    }

    public function updateOrderStatus($order_id, $status) {
        $this->query("UPDATE tbl_orders SET status = :status WHERE order_id = :order_id");
        $this->bind(':status', $status);
        $this->bind(':order_id', $order_id);
        return $this->execute();
    }

    public function getAllPayments() {
        $this->query("SELECT * FROM tbl_payment");
        return $this->resultSet();
    }

    public function saveConfirmOrder($data) {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_confirmorder (id, order_id, user_id, payment, rekening_name, image_name, alamat, tgl_pay) VALUES (:id, :order_id, :user_id, :payment, :rekening_name, :image_name, :alamat, :tgl_pay)");
        
        $this->bind(':id', $id);
        $this->bind(':order_id', $data['order_id']);
        $this->bind(':user_id', $data['user_id']);
        $this->bind(':payment', $data['payment']);
        $this->bind(':rekening_name', $data['rekening_name']);
        $this->bind(':image_name', $data['image_name']);
        $this->bind(':alamat', $data['alamat']);
        $this->bind(':tgl_pay', $data['tgl_pay']);
        
        return $this->execute();
    }
}
