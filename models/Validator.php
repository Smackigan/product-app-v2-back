<?php

require_once('./database/DB.php');

class Validator
{

    public static function validate($data)
    {
        $allErrors = [];
        $sku = trim($data['sku']);
        $name = trim($data['name']);
        $price = trim($data['price']);
        $productType = $data['productType'];
        $allErrors = array_merge($allErrors, Validator::validateUniqueSku($sku));
        $allErrors = array_merge($allErrors, Validator::validateSku($sku));
        $allErrors = array_merge($allErrors, Validator::validateName($name));
        $allErrors = array_merge($allErrors, Validator::validatePrice($price));
        $allErrors = array_merge($allErrors, Validator::validateProductData($productType, $data));
        return $allErrors;
    }

    public static function validateUniqueSku($sku)
    {
        $uniqueSkuError = [];

        $productsTable = new ProductsTable();
        $isUnique = $productsTable->isSkuUnique($sku);

        if (!$isUnique) {
            $uniqueSkuError['sku'] = 'SKU must be unique';
        }

        return $uniqueSkuError;
    }

    public static function validateSku($sku)
    {
        $skuErrors = [];

        if (empty($sku)) {
            $skuErrors['sku'] = 'Please provide the SKU';
        } elseif (strlen($sku) > 10) {
            $skuErrors['sku'] = 'SKU must be less than 10 characters long';
        }

        return $skuErrors;
    }

    public static function validateName($name)
    {
        $nameErrors = [];

        if (empty($name)) {
            $nameErrors['name'] = 'Please provide the name';
        } elseif (strlen($name) > 30) {
            $nameErrors['name'] = 'Product name is too long';
        } elseif (!is_string($name)) {
            $nameErrors['name'] = 'Please provide the data of indicated type';
        }
        return $nameErrors;
    }

    public static function validatePrice($price)
    {
        $priceErrors = [];

        if (empty($price)) {
            $priceErrors['price'] = 'Please provide the price';
        } elseif (!is_numeric($price)) {
            $priceErrors['price'] = 'Please provide a valid numeric price';
        } elseif ($price <= 0) {
            $priceErrors['price'] = 'Price must be greater than zero';
        } elseif ($price > 999999999999.99) {
            $priceErrors['price'] = 'Price is too big';
        }
        return $priceErrors;
    }

    public static function validateProductData($productType, $data)
    {
        $allErrors = [];
        $productTypeValidator = new ProductTypeValidator();

        // Validation and errors based on the selected product type
        switch ($productType) {
            case 'DVD':
                $size = $_POST['size'];
                $allErrors = array_merge($allErrors, $productTypeValidator->validateSize($size));
                break;
            case 'book':
                $weight = $_POST['weight'];
                $allErrors = array_merge($allErrors, $productTypeValidator->validateWeight($weight));
                break;
            case 'furniture':
                $height = $_POST['height'];
                $width = $_POST['width'];
                $length = $_POST['length'];
                $allErrors = array_merge($allErrors, $productTypeValidator->validateDimensions($height, $width, $length));
                break;
            default:
                // Invalid product type
                $errors['productTypeError'] = 'Invalid product type';
                $allErrors = array_merge($allErrors, $errors);
                break;
        }
        return $allErrors;
    }
}

class ProductTypeValidator
{

    public function validateSize($size)
    {
        $sizeErrors = [];

        // Validation rule for size
        if (empty($size)) {
            $sizeErrors['size'] = 'Please provide the size';
        } elseif (strlen($size) > 10) {
            $sizeErrors['size'] = 'Size is too big';
        } elseif ($size <= 0) {
            $sizeErrors['size'] = 'Size must be greater than zero';
        } elseif (!is_numeric($size)) {
            $sizeErrors['size'] = 'Please provide a valid numeric data';
        }
        return $sizeErrors;
    }

    public function validateWeight($weight)
    {
        $weightErrors = [];

        // Validation rule for weight
        if (empty($weight)) {
            $weightErrors['weight'] = 'Please provide the weight';
        } elseif (strlen($weight) > 10) {
            $weightErrors['weight'] = 'Weight is too big';
        } elseif ($weight <= 0) {
            $weightErrors['weight'] = 'Weight must be greater than zero';
        } elseif (!is_numeric($weight)) {
            $weightErrors['weight'] = 'Please provide a valid numeric data';
        }
        return $weightErrors;
    }

    public function validateDimensions($height, $width, $length)
    {
        $dimensionErrors = [];

        // Validation rule for height
        if (empty($height)) {
            $dimensionErrors['height'] = 'Please provide the height';
        } elseif (!is_numeric($height)) {
            $dimensionErrors['height'] = 'Please provide a valid numeric height';
        } elseif (strlen($height) > 10) {
            $dimensionErrors['height'] = 'Height is too big';
        } elseif ($height <= 0) {
            $dimensionErrors['height'] = 'Height must be greater than zero';
        }

        // Validation rule for width
        if (empty($width)) {
            $dimensionErrors['width'] = 'Please provide the width';
        } elseif (!is_numeric($width)) {
            $dimensionErrors['width'] = 'Please provide a valid numeric width';
        } elseif (strlen($width) > 10) {
            $dimensionErrors['width'] = 'Width is too big';
        } elseif ($width <= 0) {
            $dimensionErrors['width'] = 'Width must be greater than zero';
        }

        // Validation rule for length
        if (empty($length)) {
            $dimensionErrors['length'] = 'Please provide the length';
        } elseif (!is_numeric($length)) {
            $dimensionErrors['length'] = 'Please provide a valid numeric length';
        } elseif (strlen($length) > 10) {
            $dimensionErrors['length'] = 'Length is too big';
        } elseif ($length <= 0) {
            $dimensionErrors['length'] = 'Length must be greater than zero';
        }

        return $dimensionErrors;
    }
}