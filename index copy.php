<?php

require_once './config/db_config.php';
require_once './models/ProductsTable.php';
require_once './database/DB.php';
require_once './models/Product.php';
require_once './controllers/ProductController.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


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




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['endpoint'])) {
    $endpoint = $_GET['endpoint'];

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Convert JSON to an associative array

    if ($endpoint === '/api/add-product') {
        // Handle the /api/add-product endpoint

        // Extract data from the request
        $sku = $data['sku'];
        $name = $data['name'];
        $price = $data['price'];
        $value = $data['value'];

        // Database connection parameters
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'scandiwebapp';

        // Create a database connection
        $db = new mysqli($host, $user, $password, $database);

        // Check the connection
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Prepare the SQL statement
        $query = "INSERT INTO products (sku, name, price, value) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        if ($stmt === false) {
            die("Error in preparing statement: " . $db->error);
        }

        // Bind parameters and execute the statement
        $stmt->bind_param("ssds", $sku, $name, $price, $value);

        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => 'Product created successfully',
            ];
            echo json_encode($response);
        } else {
            http_response_code(500); // Internal Server Error
            $response = [
                'success' => false,
                'message' => 'Product creation failed',
            ];
            echo json_encode($response);
        }

        // Close the statement and database connection
        $stmt->close();
        $db->close();
    }
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['endpoint'])) {
//     $endpoint = $_GET['endpoint'];

//     if ($endpoint === '/api/add-product') {
//         // Handle the /api/add-product endpoint as before

//         $productType = $_POST['productType'];
//         $data = $_POST;

//         // Mock response data
//         $response = [
//             'message' => 'Product created successfully',
//             'productType' => $productType,
//             'data' => $data,
//         ];

//         // Return the mock response data as JSON
//         echo json_encode($response);
//         exit();
//     } else {
//         // Handle the case where the endpoint doesn't exist
//         header('HTTP/1.1 404 Not Found');
//         echo json_encode(['error' => 'Endpoint not found']);
//         exit();
//     }
// }

// http_response_code(404);
// echo json_encode(['error' => 'Endpoint not found']);

// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     // It's an OPTIONS request, so respond with the CORS headers
//     header('HTTP/1.1 200 OK');
//     exit();
// }

// http://scandi-react/index.php?endpoint=/api/get-product