<?php

use models\productTypes\DVD;
use models\productTypes\Book;
use models\productTypes\Furniture;

session_start();

// require_once('./database/DB.php');
require_once('./core/Controller.php');
require_once('./models/Validator.php');
require_once('./models/ProductsTable.php');
require_once('./models/Product.php');
require_once('./models/productTypes/DVD.php');
require_once('./models/productTypes/Book.php');
require_once('./models/productTypes/Furniture.php');

class ProductController extends Controller
{

    public function createNewProduct($data)
    {

        // Extract data from the request
        $productType = $data['productType'];
        error_log(print_r($productType));

        // Handle product creation based on productType
        $product = ProductFactory::Create($productType, $data);

        if ($product) {
            // Insert data to the DB
            $productsTable = new ProductsTable();
            $productsTable->insertProduct($product);

            // prepare success response
            $response = array('success' => true, 'message' => '');
            error_log(print_r($response, true));
            error_log(json_encode($response));

            return $response;
        } else {
            $response = array('success' => false);
            // error_log(print_r($response, true));
            // error_log(json_encode($response));

            return $response;
        }
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

// $productController = new ProductController();
// $productController->createNewProduct();