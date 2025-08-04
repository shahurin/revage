<?php
class RecipeModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getSuggestedRecipes($userId, $limit = 5) {
        // ユーザーの在庫を取得
        $inventory = $this->getUserInventory($userId);
        if (empty($inventory)) {
            return [];
        }
        
        $productIds = array_column($inventory, 'product_id');
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        
        $sql = "SELECT r.id, r.name, r.cooking_time, 
                       COUNT(ri.product_id) AS matched_ingredients,
                       (SELECT COUNT(*) FROM recipe_ingredients WHERE recipe_id = r.id) AS total_ingredients,
                       ROUND(COUNT(ri.product_id) / (SELECT COUNT(*) FROM recipe_ingredients WHERE recipe_id = r.id) * 100 AS match_percentage
                FROM recipes r
                JOIN recipe_ingredients ri ON r.id = ri.recipe_id
                WHERE ri.product_id IN ($placeholders)
                GROUP BY r.id
                HAVING matched_ingredients > 0
                ORDER BY match_percentage DESC, matched_ingredients DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $params = array_merge($productIds, [$limit]);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }
    
    public function getRecipeDetail($recipeId) {
        $sql = "SELECT r.*, 
                       GROUP_CONCAT(p.name SEPARATOR ', ') AS ingredient_names
                FROM recipes r
                LEFT JOIN recipe_ingredients ri ON r.id = ri.recipe_id
                LEFT JOIN products p ON ri.product_id = p.id
                WHERE r.id = ?
                GROUP BY r.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$recipeId]);
        
        return $stmt->fetch();
    }
    
    private function getUserInventory($userId) {
        $stmt = $this->db->prepare("SELECT product_id FROM user_inventory WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
?>