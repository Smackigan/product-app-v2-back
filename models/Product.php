<?php

namespace Models;

abstract class Product
{
    public $id;
    public $sku;
    public $name;
    public $price;
    public $value;

    public function __construct($id, $sku, $name, $price, $value)
    {
        $this->setId($id);
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        $this->setValue($value);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setData($data)
    {
        $this->setSku($data['sku']);
        $this->setName($data['name']);
        $this->setPrice($data['price']);
    }
}

class GetProducts extends Product
{

    public function __construct($id, $sku, $name, $price, $value)
    {

        parent::__construct($id, $sku, $name, $price, $value);
    }
}