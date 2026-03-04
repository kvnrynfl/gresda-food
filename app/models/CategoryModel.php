<?php

/**
 * Category Model
 * 
 * Updated for new schema with slug, description, icon, sort_order, is_active
 * Table: tbl_category
 */
class CategoryModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->query("SELECT * FROM tbl_category ORDER BY sort_order ASC");
        return $this->resultSet();
    }

    public function getActive()
    {
        $this->query("SELECT * FROM tbl_category WHERE is_active = 1 ORDER BY sort_order ASC");
        return $this->resultSet();
    }

    public function getById($id)
    {
        $this->query("SELECT * FROM tbl_category WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function getBySlug($slug)
    {
        $this->query("SELECT * FROM tbl_category WHERE slug = :slug");
        $this->bind(':slug', $slug);
        return $this->single();
    }

    public function create($data)
    {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_category (id, name, slug, description, icon, sort_order, is_active) 
                       VALUES (:id, :name, :slug, :desc, :icon, :sort, :active)");
        $this->bind(':id', $id);
        $this->bind(':name', $data['name']);
        $this->bind(':slug', $data['slug'] ?? $this->generateSlug($data['name']));
        $this->bind(':desc', $data['description'] ?? null);
        $this->bind(':icon', $data['icon'] ?? null);
        $this->bind(':sort', $data['sort_order'] ?? 0);
        $this->bind(':active', $data['is_active'] ?? 1);
        return $this->execute();
    }

    public function update($id, $data)
    {
        $this->query("UPDATE tbl_category SET name = :name, slug = :slug, description = :desc, icon = :icon, sort_order = :sort, is_active = :active WHERE id = :id");
        $this->bind(':name', $data['name']);
        $this->bind(':slug', $data['slug'] ?? $this->generateSlug($data['name']));
        $this->bind(':desc', $data['description'] ?? null);
        $this->bind(':icon', $data['icon'] ?? null);
        $this->bind(':sort', $data['sort_order'] ?? 0);
        $this->bind(':active', $data['is_active'] ?? 1);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function delete($id)
    {
        $this->query("DELETE FROM tbl_category WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function toggleActive($id)
    {
        $this->query("UPDATE tbl_category SET is_active = IF(is_active = 1, 0, 1) WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Get category with food count
     */
    public function getAllWithFoodCount()
    {
        $this->query("
            SELECT c.*, COUNT(f.id) as food_count 
            FROM tbl_category c 
            LEFT JOIN tbl_food f ON c.id = f.category_id AND f.is_active = 1
            GROUP BY c.id 
            ORDER BY c.sort_order ASC
        ");
        return $this->resultSet();
    }

    private function generateSlug($name)
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
