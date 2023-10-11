<?php

use Models\GetProducts;
use Models\Product;

require_once('../database/DB.php');
require_once('Product.php');

// All opertions with DB
class ProductsTable
{
    protected $conn;

    public function __construct()
    {
        $this->conn = new DB();
    }

    // Save product to DB
    public function insertProduct(Product $product)
    {
        $sku = $product->getSku();
        $name = $product->getName();
        $price = $product->getPrice();
        $value = $product->getValue();

        // Add product to table
        $db = $this->conn;
        $sql = "INSERT INTO products (sku, name, price, value) VALUES (?, ?, ?, ?)";
        $stmt = $db->getConnection($sql);

        mysqli_stmt_bind_param($stmt, "ssds", $sku, $name, $price, $value);
        mysqli_stmt_execute($stmt);

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }

    // Chech for Unique SKU
    public function isSkuUnique($sku)
    {
        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM products WHERE sku = ?';
        $stmt = $db->getConnection($sql);
        mysqli_stmt_bind_param($stmt, 's', $sku);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return $count === 0; // Return true if unique
    }

    // Get all products from DB
    public function getAllProducts()
    {
        $sql = 'SELECT * FROM products';
        $stmt = $this->conn->getConnection($sql);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $products = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $product = new GetProducts($row['id'], $row['sku'], $row['name'], $row['price'], $row['value']);
            $products[] = $product;
        }
        mysqli_stmt_close($stmt);

        return $products;
    }

    // Delete all products from DB
    public function deleteProducts($selectedIDs)
    {
        $ids = implode(",", $selectedIDs);
        $sql = "DELETE FROM products WHERE id IN ($ids)";
        $stmt = $this->conn->getConnection($sql);

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
        }
    }
}
