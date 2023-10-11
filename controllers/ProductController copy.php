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

    public function createNewProduct()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-type: application/json');
            $productType = $_POST['productType'];
            $data = $_POST;

            // $allErrors = Validator::validate($data);

            $allErrors = [];

            // print_r($allErrors);

            if (empty($allErrors)) {

                $product = ProductFactory::Create($productType, $data);

                // Insert data to the DB
                $productsTable = new ProductsTable();
                $productsTable->insertProduct($product);

                // prepare success response
                $response = array('success' => true, 'message' => '');
                error_log(print_r($response, true));
                error_log(json_encode($response));

                echo json_encode($response);
            } else {

                $response = array('success' => false, 'errors' => $allErrors);
                // error_log(print_r($response, true));
                // error_log(json_encode($response));

                echo json_encode($response);
            }
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

$productController = new ProductController();
$productController->createNewProduct();
