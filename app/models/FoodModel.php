<?php

/**
 * Food Model
 * 
 * Updated to use category_id FK instead of slug string.
 * Table: tbl_food
 */
class FoodModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all food items with category name
     */
    public function getAll()
    {
        $this->query("
            SELECT f.*, c.name as category_name, c.slug as category_slug 
            FROM tbl_food f 
            LEFT JOIN tbl_category c ON f.category_id = c.id 
            ORDER BY f.created_at DESC
        ");
        return $this->resultSet();
    }

    /**
     * Get active food items with category name
     */
    public function getActive()
    {
        $this->query("
            SELECT f.*, c.name as category_name, c.slug as category_slug 
            FROM tbl_food f 
            LEFT JOIN tbl_category c ON f.category_id = c.id 
            WHERE f.is_active = 1 
            ORDER BY RAND()
        ");
        return $this->resultSet();
    }

    /**
     * Count active food items
     */
    public function countActive()
    {
        $this->query("SELECT COUNT(*) as total FROM tbl_food WHERE is_active = 1");
        return $this->single()['total'];
    }

    /**
     * Get food by ID with category info
     */
    public function getById($id)
    {
        $this->query("
            SELECT f.*, c.name as category_name, c.slug as category_slug 
            FROM tbl_food f 
            LEFT JOIN tbl_category c ON f.category_id = c.id 
            WHERE f.id = :id
        ");
        $this->bind(':id', $id);
        return $this->single();
    }

    /**
     * Get food items by category slug
     */
    public function getByCategory($categorySlug)
    {
        $this->query("
            SELECT f.*, c.name as category_name, c.slug as category_slug 
            FROM tbl_food f 
            JOIN tbl_category c ON f.category_id = c.id 
            WHERE c.slug = :slug AND f.is_active = 1
        ");
        $this->bind(':slug', $categorySlug);
        return $this->resultSet();
    }

    /**
     * Get filtered food items (search + category + sort)
     */
    public function getFiltered($keyword = '', $categorySlug = 'all', $sort = 'newest')
    {
        $sql = "SELECT f.*, c.name as category_name, c.slug as category_slug 
                FROM tbl_food f 
                LEFT JOIN tbl_category c ON f.category_id = c.id 
                WHERE f.is_active = 1";

        if ($categorySlug !== 'all') {
            $sql .= " AND c.slug = :category";
        }

        if (!empty($keyword)) {
            $sql .= " AND (f.name LIKE :keyword1 OR f.description LIKE :keyword2)";
        }

        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY f.price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY f.price DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY f.name ASC";
                break;
            case 'bestseller':
                $sql .= " ORDER BY f.is_bestseller DESC, f.name ASC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY f.created_at DESC, f.id DESC";
                break;
        }

        $this->query($sql);

        if ($categorySlug !== 'all') {
            $this->bind(':category', $categorySlug);
        }
        if (!empty($keyword)) {
            $this->bind(':keyword1', '%' . $keyword . '%');
            $this->bind(':keyword2', '%' . $keyword . '%');
        }

        return $this->resultSet();
    }

    /**
     * Create a new food item
     */
    public function create($data)
    {
        $id = UUID::v4();
        $slug = $this->generateSlug($data['name']);

        $this->query("INSERT INTO tbl_food (id, category_id, name, slug, price, description, image, weight, is_bestseller, is_new, is_spicy, is_active) 
                       VALUES (:id, :cat_id, :name, :slug, :price, :desc, :img, :weight, :bestseller, :new, :spicy, :active)");
        $this->bind(':id', $id);
        $this->bind(':cat_id', $data['category_id']);
        $this->bind(':name', $data['name']);
        $this->bind(':slug', $slug);
        $this->bind(':price', $data['price']);
        $this->bind(':desc', $data['description'] ?? '');
        $this->bind(':img', $data['image'] ?? null);
        $this->bind(':weight', $data['weight'] ?? null);
        $this->bind(':bestseller', $data['is_bestseller'] ?? 0);
        $this->bind(':new', $data['is_new'] ?? 0);
        $this->bind(':spicy', $data['is_spicy'] ?? 0);
        $this->bind(':active', $data['is_active'] ?? 1);
        return $this->execute();
    }

    /**
     * Update a food item
     */
    public function update($id, $data)
    {
        $this->query("UPDATE tbl_food SET category_id = :cat_id, name = :name, price = :price, description = :desc, 
                       image = :img, weight = :weight, is_bestseller = :bestseller, is_new = :new, is_spicy = :spicy, 
                       is_active = :active WHERE id = :id");
        $this->bind(':cat_id', $data['category_id']);
        $this->bind(':name', $data['name']);
        $this->bind(':price', $data['price']);
        $this->bind(':desc', $data['description'] ?? '');
        $this->bind(':img', $data['image']);
        $this->bind(':weight', $data['weight'] ?? null);
        $this->bind(':bestseller', $data['is_bestseller'] ?? 0);
        $this->bind(':new', $data['is_new'] ?? 0);
        $this->bind(':spicy', $data['is_spicy'] ?? 0);
        $this->bind(':active', $data['is_active'] ?? 1);
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Delete a food item
     */
    public function delete($id)
    {
        $this->query("DELETE FROM tbl_food WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function toggleActive($id)
    {
        $this->query("UPDATE tbl_food SET is_active = IF(is_active = 1, 0, 1) WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Get top selling items
     */
    public function getTopSelling($limit = 10)
    {
        $this->query("
            SELECT f.*, c.name as category_name, c.slug as category_slug, COALESCE(SUM(d.qty), 0) as total_sold
            FROM tbl_food f
            LEFT JOIN tbl_category c ON f.category_id = c.id
            LEFT JOIN tbl_order_details d ON f.id = d.food_id
            LEFT JOIN tbl_orders o ON d.order_id = o.id AND o.status NOT IN ('pending_payment', 'cancelled')
            WHERE f.is_active = 1
            GROUP BY f.id
            ORDER BY total_sold DESC
            LIMIT :limit
        ");
        $this->bind(':limit', $limit);
        return $this->resultSet();
    }

    /**
     * Generate URL-safe slug from name
     */
    private function generateSlug($name)
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
