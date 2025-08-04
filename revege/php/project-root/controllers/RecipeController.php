<?php
class RecipeController {
    private $recipeModel;
    
    public function __construct() {
        $this->recipeModel = new RecipeModel();
    }
    
    public function suggestRecipes() {
        $userId = $_SESSION['user_id'] ?? 1; // 実際は認証システムから取得
        $recipes = $this->recipeModel->getSuggestedRecipes($userId);
        
        include 'views/recipes/suggest.php';
    }
    
    public function showRecipeDetail($recipeId) {
        $recipe = $this->recipeModel->getRecipeDetail($recipeId);
        
        if (!$recipe) {
            header("HTTP/1.0 404 Not Found");
            include 'views/errors/404.php';
            exit;
        }
        
        include 'views/recipes/detail.php';
    }
}
?>