<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function searchProducts($searchTerm, $category = null, $minPrice = null, $maxPrice = null) {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE 1=1";
        $params = [];

        if (!empty($searchTerm)) {
            $sql .= " AND p.name LIKE :searchTerm";
            $params[':searchTerm'] = "%$searchTerm%";
        }

        if (!empty($category)) {
            $sql .= " AND c.name = :category";
            $params[':category'] = $category;
        }

        if ($minPrice !== null) {
            $sql .= " AND p.price >= :minPrice";
            $params[':minPrice'] = $minPrice;
        }

        if ($maxPrice !== null) {
            $sql .= " AND p.price <= :maxPrice";
            $params[':maxPrice'] = $maxPrice;
        }

        $sql .= " ORDER BY p.name";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("検索エラー: " . $e->getMessage() . "\nSQL: " . $sql);
            return [];
        }
    }

    public function getCategories() {
        try {
            $stmt = $this->db->query("SELECT name FROM categories ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        } catch (PDOException $e) {
            error_log("カテゴリ取得エラー: " . $e->getMessage());
            return [];
        }
    }
}