<?php

require_once 'ProductsTable.php';

$productsTable = new ProductsTable();

// API-точка для получения всех продуктов
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $products = $productsTable->getAllProducts();
    echo json_encode($products);
}
