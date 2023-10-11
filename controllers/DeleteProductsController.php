<?php

session_start();

require_once('./core/Controller.php');
require_once('./models/ProductsTable.php');

class DeleteProductsController extends Controller
{
    public function deleteProducts()
    {
        // Parse JSON data from the request
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['selectedIDs'])) {
            // Retrieve selectedIDs array from the request
            $selectedIDs = $data['selectedIDs'];

            // Create ProductsTable class and call delete method
            $productsTable = new ProductsTable();
            $productsTable->deleteProducts($selectedIDs);

            // success response
            $response = ['success' => true];
        } else {
            // error response
            $response = ['success' => false, 'message' => 'Missing selectedIDs'];
        }

        // Return the response as JSON
        echo json_encode($response);
    }
}

// $productController = new DeleteProductsController();
// $productController->deleteAllProducts();