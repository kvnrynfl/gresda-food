<?php

/**
 * Order Model
 * 
 * Updated for new schema with:
 * - Proper order number generation
 * - Direct lookup methods (no more looping through all orders)
 * - Separate monetary columns
 * - Status timestamps
 * 
 * Tables: tbl_orders, tbl_order_details, tbl_cart, tbl_payment_confirmations, tbl_payment_methods
 */
class OrderModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    // ─── Orders ─────────────────────────────────────────────────────

    /**
     * Get all orders (admin view) with user info
     */
    public function getAllOrders()
    {
        $this->query("
            SELECT o.*, u.username, u.email, u.full_name as customer_name 
            FROM tbl_orders o 
            LEFT JOIN tbl_users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC
        ");
        return $this->resultSet();
    }

    /**
     * Get recent orders (admin dashboard)
     */
    public function getRecentOrders($limit = 5)
    {
        $this->query("
            SELECT o.*, u.username, u.email, u.full_name as customer_name 
            FROM tbl_orders o 
            LEFT JOIN tbl_users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC 
            LIMIT :limit
        ");
        $this->bind(':limit', $limit);
        return $this->resultSet();
    }

    /**
     * Get orders for a specific user
     */
    public function getOrdersByUser($userId)
    {
        $this->query("SELECT * FROM tbl_orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->bind(':user_id', $userId);
        return $this->resultSet();
    }

    /**
     * Get order by ID (direct lookup — no more looping)
     */
    public function getOrderById($orderId)
    {
        $this->query("
            SELECT o.*, u.username, u.email, u.full_name as customer_name 
            FROM tbl_orders o 
            LEFT JOIN tbl_users u ON o.user_id = u.id 
            WHERE o.id = :id
        ");
        $this->bind(':id', $orderId);
        return $this->single();
    }

    /**
     * Get order by ID only if owned by user (secure direct lookup)
     */
    public function getOrderByIdAndUser($orderId, $userId)
    {
        $this->query("SELECT * FROM tbl_orders WHERE id = :id AND user_id = :user_id");
        $this->bind(':id', $orderId);
        $this->bind(':user_id', $userId);
        return $this->single();
    }

    /**
     * Get order status counts (admin dashboard)
     */
    public function getOrderStatusCounts()
    {
        $this->query("SELECT status, COUNT(*) as count FROM tbl_orders GROUP BY status");
        return $this->resultSet();
    }

    /**
     * Get monthly revenue (admin dashboard)
     */
    public function getRevenueByMonth()
    {
        $this->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(grand_total) as revenue 
            FROM tbl_orders 
            WHERE status IN ('confirmed', 'processing', 'delivering', 'finished') 
            GROUP BY month ORDER BY month ASC LIMIT 6
        ");
        return $this->resultSet();
    }

    /**
     * Get total revenue
     */
    public function getTotalRevenue()
    {
        $this->query("SELECT SUM(grand_total) as total_revenue FROM tbl_orders WHERE status IN ('confirmed', 'processing', 'delivering', 'finished')");
        $result = $this->single();
        return $result['total_revenue'] ?? 0;
    }

    /**
     * Create a new order
     */
    public function createOrder($userId, $subtotal, $taxAmount, $shippingCost, $grandTotal, $address, $notes = null)
    {
        $id = UUID::v4();
        $orderNumber = UUID::orderNumber();

        $this->query("INSERT INTO tbl_orders (id, order_number, user_id, status, subtotal, tax_amount, shipping_cost, grand_total, shipping_address, notes) 
                       VALUES (:id, :order_num, :user_id, 'pending_payment', :subtotal, :tax, :shipping, :grand, :address, :notes)");
        $this->bind(':id', $id);
        $this->bind(':order_num', $orderNumber);
        $this->bind(':user_id', $userId);
        $this->bind(':subtotal', $subtotal);
        $this->bind(':tax', $taxAmount);
        $this->bind(':shipping', $shippingCost);
        $this->bind(':grand', $grandTotal);
        $this->bind(':address', $address);
        $this->bind(':notes', $notes);
        $this->execute();

        return $id;
    }

    /**
     * Update order status with timestamp tracking
     */
    public function updateOrderStatus($orderId, $status)
    {
        $timestampField = '';
        switch ($status) {
            case 'confirmed':
                $timestampField = ', confirmed_at = NOW()';
                break;
            case 'delivering':
                $timestampField = ', delivering_at = NOW()';
                break;
            case 'finished':
                $timestampField = ', finished_at = NOW()';
                break;
            case 'cancelled':
                $timestampField = ', cancelled_at = NOW()';
                break;
        }

        $this->query("UPDATE tbl_orders SET status = :status{$timestampField} WHERE id = :id");
        $this->bind(':status', $status);
        $this->bind(':id', $orderId);
        return $this->execute();
    }

    /**
     * Cancel an order with reason
     */
    public function cancelOrder($orderId, $reason = null)
    {
        $this->query("UPDATE tbl_orders SET status = 'cancelled', cancelled_at = NOW(), cancelled_reason = :reason WHERE id = :id");
        $this->bind(':reason', $reason);
        $this->bind(':id', $orderId);
        return $this->execute();
    }

    /**
     * Check if user has any completed (finished) orders
     */
    public function hasCompletedOrder($userId)
    {
        $this->query("SELECT 1 FROM tbl_orders WHERE user_id = :user_id AND status = 'finished' LIMIT 1");
        $this->bind(':user_id', $userId);
        return !empty($this->single());
    }

    // ─── Order Details ──────────────────────────────────────────────

    /**
     * Add an item to order details
     */
    public function addDetailItem($orderId, $foodId, $foodName, $qty, $unitPrice)
    {
        $id = UUID::v4();
        $subtotal = $qty * $unitPrice;

        $this->query("INSERT INTO tbl_order_details (id, order_id, food_id, food_name, qty, unit_price, subtotal) 
                       VALUES (:id, :order_id, :food_id, :food_name, :qty, :price, :subtotal)");
        $this->bind(':id', $id);
        $this->bind(':order_id', $orderId);
        $this->bind(':food_id', $foodId);
        $this->bind(':food_name', $foodName);
        $this->bind(':qty', $qty);
        $this->bind(':price', $unitPrice);
        $this->bind(':subtotal', $subtotal);
        return $this->execute();
    }

    /**
     * Get order details with food info
     */
    public function getOrderDetails($orderId)
    {
        $this->query("
            SELECT d.*, f.image, f.slug as food_slug
            FROM tbl_order_details d 
            LEFT JOIN tbl_food f ON d.food_id = f.id 
            WHERE d.order_id = :order_id
        ");
        $this->bind(':order_id', $orderId);
        return $this->resultSet();
    }

    // ─── Cart ───────────────────────────────────────────────────────

    /**
     * Get cart items for a user with food details
     */
    public function getCartItemsByUser($userId)
    {
        $this->query("
            SELECT c.*, c.id as detail_id, f.name, f.price, f.image, f.slug as food_slug
            FROM tbl_cart c 
            JOIN tbl_food f ON c.food_id = f.id 
            WHERE c.user_id = :user_id
        ");
        $this->bind(':user_id', $userId);
        return $this->resultSet();
    }

    /**
     * Add item to cart (or increment qty if exists)
     */
    public function addToCart($userId, $foodId, $qty = 1)
    {
        $this->query("SELECT * FROM tbl_cart WHERE user_id = :user_id AND food_id = :food_id");
        $this->bind(':user_id', $userId);
        $this->bind(':food_id', $foodId);
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
            $this->bind(':user_id', $userId);
            $this->bind(':food_id', $foodId);
            $this->bind(':qty', $qty);
            return $this->execute();
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateCartQty($detailId, $qty)
    {
        $this->query("UPDATE tbl_cart SET qty = :qty WHERE id = :id");
        $this->bind(':qty', $qty);
        $this->bind(':id', $detailId);
        return $this->execute();
    }

    /**
     * Remove item from cart
     */
    public function removeCartItem($detailId)
    {
        $this->query("DELETE FROM tbl_cart WHERE id = :id");
        $this->bind(':id', $detailId);
        return $this->execute();
    }

    /**
     * Get single cart item
     */
    public function getCartItemById($detailId)
    {
        $this->query("SELECT c.*, f.price FROM tbl_cart c JOIN tbl_food f ON c.food_id = f.id WHERE c.id = :id");
        $this->bind(':id', $detailId);
        return $this->single();
    }

    // ─── Payment Methods & Confirmations ────────────────────────────

    /**
     * Get all active payment methods
     */
    public function getAllPaymentMethods()
    {
        $this->query("SELECT * FROM tbl_payment_methods WHERE is_active = 1 ORDER BY sort_order ASC");
        return $this->resultSet();
    }

    /**
     * Get payment method by ID
     */
    public function getPaymentMethodById($id)
    {
        $this->query("SELECT * FROM tbl_payment_methods WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    /**
     * Save payment confirmation
     */
    public function savePaymentConfirmation($data)
    {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_payment_confirmations (id, order_id, user_id, payment_method_id, sender_name, sender_account, amount, proof_image, payment_date) 
                       VALUES (:id, :order_id, :user_id, :pm_id, :sender_name, :sender_account, :amount, :proof, :pay_date)");
        $this->bind(':id', $id);
        $this->bind(':order_id', $data['order_id']);
        $this->bind(':user_id', $data['user_id']);
        $this->bind(':pm_id', $data['payment_method_id']);
        $this->bind(':sender_name', $data['sender_name']);
        $this->bind(':sender_account', $data['sender_account'] ?? null);
        $this->bind(':amount', $data['amount']);
        $this->bind(':proof', $data['proof_image']);
        $this->bind(':pay_date', $data['payment_date']);
        return $this->execute();
    }

    /**
     * Get payment confirmation for an order
     */
    public function getPaymentConfirmation($orderId)
    {
        $this->query("
            SELECT pc.*, pm.name as payment_method_name, pm.type as payment_type, pm.account_number, pm.account_name, pm.icon as payment_icon
            FROM tbl_payment_confirmations pc
            LEFT JOIN tbl_payment_methods pm ON pc.payment_method_id = pm.id
            WHERE pc.order_id = :order_id
        ");
        $this->bind(':order_id', $orderId);
        return $this->single();
    }

    /**
     * Update payment confirmation status
     */
    public function updatePaymentStatus($confirmId, $status, $adminId = null, $rejectionReason = null)
    {
        if ($status === 'verified') {
            $this->query("UPDATE tbl_payment_confirmations SET status = :status, verified_at = NOW(), verified_by = :admin WHERE id = :id");
        } else {
            $this->query("UPDATE tbl_payment_confirmations SET status = :status, rejection_reason = :reason WHERE id = :id");
            $this->bind(':reason', $rejectionReason);
        }
        $this->bind(':status', $status);
        $this->bind(':admin', $adminId);
        $this->bind(':id', $confirmId);
        return $this->execute();
    }
}
