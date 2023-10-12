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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    if ($endpoint === '/api/get-product') {
        // GET PRODUCTS
        handleGetProduct();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if ($endpoint === '/api/add-product') {
        // ADD PRODUCTS
        handleAddProduct($data);
    } elseif ($endpoint === '/api/delete-products') {
        // DELETE PRODUCTS
        handleDeleteProducts($data);
    }
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
    // Create an instance of the DeleteProductsController
    $deleteProductsController = new DeleteProductsController();

    // Call the deleteProducts method to handle the deletion
    $deleteProductsController->deleteProducts();
}


// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['REQUEST_URI'])) {
//     $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//     if ($urlPath === '/api/get-product') {
//         // Handle the request here
//     }


// CHECK UNIQUE SKU
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'check-sku') {
//     // Check if the 'sku' parameter is set in the URL
//     if (isset($_GET['sku'])) {
//         // Get the SKU from the URL
//         $sku = $_GET['sku'];

//         // Create an instance of the ProductsTable class
//         $productsTable = new ProductsTable();

//         // Use the isSkuUnique function to check if SKU is unique
//         $isUnique = $productsTable->isSkuUnique($sku);

//         // Return the result as JSON
//         echo json_encode($isUnique);
//         exit();
//     }
// }

// VALIDATION CHECK
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'check-sku') {
//     // Check if the 'sku' parameter is set in the URL
//     if ($endpoint === '/api/validate-input') {
//         $type = $_POST['type'];
//         $value = $_POST['value'];

//         // Perform the appropriate validation based on the "type"
//         $validationResult = null;
//         if ($type === 'sku') {
//             $validationResult = isSkuUnique($value);
//         } elseif ($type === 'anotherType') {
//             // Perform a different type of validation
//         }

//         // Return the validation result as JSON
//         $response = ['isValid' => $validationResult];
//         echo json_encode($response);
//     }
// }