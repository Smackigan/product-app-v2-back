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


// Define the API endpoint
// GET PRODUCTS
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    if ($endpoint === '/api/get-product') {
        // Create an instance of the ProductsTable class
        $productsTable = new ProductsTable();

        // Use the getAllProducts function to retrieve product data
        $products = $productsTable->getAllProducts();

        // Return the product data as JSON
        echo json_encode($products);
        exit();
    }
}


// ADD PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Convert JSON to an associative array

    if ($endpoint === '/api/add-product') {
        // Handle the /api/add-product endpoint

        $productController = new ProductController();
        $response = $productController->createNewProduct($data);

        // Send the response as JSON
        if ($response) {
            // Return the created product data as JSON
            echo json_encode($response);
        } else {
            // Handle the case where the product creation failed
            http_response_code(500); // Internal Server Error
            echo json_encode($response);
        }
        exit();
    }
}

// CHECK UNIQUE SKU
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'check-sku') {
    // Check if the 'sku' parameter is set in the URL
    if (isset($_GET['sku'])) {
        // Get the SKU from the URL
        $sku = $_GET['sku'];

        // Create an instance of the ProductsTable class
        $productsTable = new ProductsTable();

        // Use the isSkuUnique function to check if SKU is unique
        $isUnique = $productsTable->isSkuUnique($sku);

        // Return the result as JSON
        echo json_encode($isUnique);
        exit();
    }
}

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

// REMOVE PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    error_log("Received a request for endpoint: " . $endpoint);

    if ($endpoint === '/api/delete-products') {

        // Create an instance of the DeleteProductsController
        $deleteProductsController = new DeleteProductsController();

        // Call the deleteAllProducts method to handle the deletion
        $deleteProductsController->deleteProducts();
    }
}
