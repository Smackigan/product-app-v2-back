<?php

require_once '../config/db_config.php';
require_once '../models/ProductsTable.php';
require_once '../database/DB.php';
require_once '../models/Product.php';
require_once '../controllers/ProductController.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');


// API ENDPOINTS

$request_uri = $_SERVER['REQUEST_URI'];

$uri_parts = explode('?', $request_uri);
$path = $uri_parts[0];


if ($_SERVER['REQUEST_METHOD'] === 'GET' && $path === '/api/get-product') {
    // Handle the GET request for the 'get-product' API
    handleGetProduct();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $path === '/api/add-product') {
    // Handle the POST request for the 'add-product' API
    $data = getRequestData();
    handleAddProduct($data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $path === '/api/delete-products') {
    // Handle the DELETE request for the 'delete-products' API
    $data = getRequestData();
    handleDeleteProducts($data);
} else {
    // Handle unknown API endpoints
    echo "Unknown API endpoint: $path";
}

// GET PRODUCTS
function handleGetProduct()
{
    // Create an instance of the ProductsTable
    $productsTable = new ProductsTable();

    // Use getAllProducts function to retrieve product data
    $products = $productsTable->getAllProducts();

    // Return the product data as JSON
    echo json_encode($products);
    exit();
}

// ADD PRODUCTS
function handleAddProduct($data)
{
    $productController = new ProductController();
    $response = $productController->createNewProduct($data);

    // Send the response as JSON
    if ($response) {
        // Return the created product data as JSON
        echo json_encode($response);
    } else {
        // Product creation failed
        http_response_code(500);
        echo json_encode(['error' => 'Product creation failed']);
    }
    exit();
}

// DELETE PRODUCTS
function handleDeleteProducts($data)
{
    // Create an instance of ProductController
    $productController = new ProductController();

    // Call the deleteProducts method to handle the deletion
    $response = $productController->deleteProducts($data);
}

// Helpers function. Read request from and decode 
function getRequestData()
{
    $jsonData = file_get_contents('php://input');
    return json_decode($jsonData, true);
}
