<?php

use models\productTypes\DVD;
use models\productTypes\Book;
use models\productTypes\Furniture;

session_start();

require_once('../core/Controller.php');
require_once('../models/Validator.php');
require_once('../models/ProductsTable.php');
require_once('../models/Product.php');
require_once('../models/productTypes/DVD.php');
require_once('../models/productTypes/Book.php');
require_once('../models/productTypes/Furniture.php');


class ProductController extends Controller
{

    // Create product
    public function createNewProduct($data)
    {
        // Extract data from the request
        $productType = $data['productType'];

        // Handle product creation based on productType
        $product = ProductFactory::Create($productType, $data);

        $allErrors = Validator::validate($data);

        if (empty($allErrors)) {
            // Insert data to the DB
            $productsTable = new ProductsTable();
            $productsTable->insertProduct($product);

            // prepare success response
            $response = array('success' => true);

            return $response;
        } else {
            $response = array('success' => false, 'errors' => $allErrors);

            return $response;
        }
    }

    // Delete product
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


class ProductFactory
{
    public static function Create($productType, $data)
    {
        $product = NULL;
        if ($productType === 'DVD') {
            $product = new DVD($data);
        } elseif ($productType === 'book') {
            $product = new Book($data);
        } elseif ($productType === 'furniture') {
            $product = new Furniture($data);
        }
        return $product;
    }
}
