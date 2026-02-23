<?php

class OrderModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function getAllCart() {
        $this->query("SELECT * FROM tbl_cart ORDER BY cart_id DESC");
        return $this->resultSet();
    }

    public function getActiveCartByUser($user_id) {
        $this->query("SELECT * FROM tbl_cart WHERE user_id = :user_id AND status = 'Cart'");
        $this->bind(':user_id', $user_id);
        return $this->single();
    }

    public function createCart($order_id, $user_id) {
        $cart_id = UUID::v4();
        $this->query("INSERT INTO tbl_cart (cart_id, order_id, user_id, status) VALUES (:cart_id, :order_id, :user_id, 'Cart')");
        $this->bind(':cart_id', $cart_id);
        $this->bind(':order_id', $order_id);
        $this->bind(':user_id', $user_id);
        return $this->execute();
    }

    public function getOrderDetails($order_id) {
        $this->query("SELECT d.*, f.name, f.price, f.image_name 
                          FROM tbl_detailorder d 
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

    public function addDetailItem($order_id, $food_id, $qty = 1) {
        // Fetch current price
        $this->query("SELECT price FROM tbl_food WHERE food_id = :food_id");
        $this->bind(':food_id', $food_id);
        $food = $this->single();
        $price = $food ? $food['price'] : 0;

        // Note: Some legacy code might not pass price_at_time, ensure it's handled safely if column is strictly required
        $detail_id = UUID::v4();
        $this->query("INSERT INTO tbl_detailorder (detail_id, order_id, food_id, qty, price_at_time) VALUES (:detail_id, :order_id, :food_id, :qty, :price)");
        $this->bind(':detail_id', $detail_id);
        $this->bind(':order_id', $order_id);
        $this->bind(':food_id', $food_id);
        $this->bind(':qty', $qty);
        $this->bind(':price', $price);
        return $this->execute();
    }

    public function updateDetailQty($order_id, $food_id, $qty) {
        $this->query("UPDATE tbl_detailorder SET qty = :qty WHERE order_id = :order_id AND food_id = :food_id");
        $this->bind(':qty', $qty);
        $this->bind(':order_id', $order_id);
        $this->bind(':food_id', $food_id);
        return $this->execute();
    }

    public function removeDetailItem($order_id, $food_id) {
        $this->query("DELETE FROM tbl_detailorder WHERE order_id = :order_id AND food_id = :food_id");
        $this->bind(':order_id', $order_id);
        $this->bind(':food_id', $food_id);
        return $this->execute();
    }

    public function updateOrderStatus($order_id, $status) {
        $this->query("UPDATE tbl_cart SET status = :status WHERE order_id = :order_id");
        $this->bind(':status', $status);
        $this->bind(':order_id', $order_id);
        return $this->execute();
    }

    public function updateCartTotal($order_id, $total) {
        $this->query("UPDATE tbl_cart SET total = :total WHERE order_id = :order_id");
        $this->bind(':total', $total);
        $this->bind(':order_id', $order_id);
        return $this->execute();
    }
}
