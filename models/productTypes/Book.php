<?php

namespace models\productTypes;

use Models\Product;

require_once('../models/Product.php');

class Book extends Product
{
    private $weight;

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function calculateValue()
    {
        $calc =  "Weight: " . strval($this->getWeight()) . "KG";
        return $calc;
    }

    public function setData($data)
    {
        error_log('Received weight: ' . $data['weight']);
        parent::setData($data);
        if (isset($data['weight'])) {
            $this->setWeight($data['weight']);
            $value = $this->calculateValue();
            $this->setValue($value);
        }
    }
}
