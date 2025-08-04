<?php
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function search() {
        try {
            $searchTerm = $_GET['search'] ?? '';
            $category = $_GET['category'] ?? null;
            $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
            $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;

            $products = $this->productModel->searchProducts(
                htmlspecialchars($searchTerm),
                $category ? htmlspecialchars($category) : null,
                $minPrice,
                $maxPrice
            );

            $categories = $this->productModel->getCategories();

            $this->renderView('results', [
                'products' => $products,
                'categories' => $categories,
                'searchTerm' => $searchTerm,
                'selectedCategory' => $category,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice
            ]);

        } catch (Exception $e) {
            error_log("検索エラー: " . $e->getMessage());
            $this->renderView('error', [
                'message' => '商品検索中にエラーが発生しました'
            ]);
        }
    }

    private function renderView($viewName, $data = []) {
        extract($data);
        $viewFile = __DIR__ . "/../views/products/{$viewName}.php";
        
        if (!file_exists($viewFile)) {
            die("ビューファイルが見つかりません: {$viewFile}");
        }
        
        include $viewFile;
    }
}