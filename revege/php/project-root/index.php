<?php
// エラー表示（開発中のみ）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 出力バッファリング
ob_start();

// 基本設定
define('APP_ROOT', __DIR__);

// ファイル読み込み
require APP_ROOT . '/config/Database.php';
require APP_ROOT . '/models/ProductModel.php';
require APP_ROOT . '/models/RecipeModel.php';
require APP_ROOT . '/controllers/ProductController.php';
require APP_ROOT . '/controllers/RecipeController.php';

// データベース接続テスト
Database::testConnection();

// 簡単なルーティング
$action = $_GET['action'] ?? 'home';

try {
    $productController = new ProductController();
    
    switch ($action) {
        case 'search':
            $productController->search();
            break;
        default:
            $productController->showSearchForm();
    }
} catch (Exception $e) {
    die("エラーが発生しました: " . $e->getMessage());
}

ob_end_flush();