<?php

namespace models\productTypes;

use Models\Product;

require_once('../models/Product.php');

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    protected function calculateValue()
    {
        $calc =  "Dimension: " . strval($this->getHeight()) . "x" . strval($this->getWidth()) . "x" . strval($this->getLength());
        return $calc;
    }

    public function setData($data)
    {
        error_log('Received dimension: ' . $data['height'] . $data['width'] . $data['length']);
        parent::setData($data);
        if (isset($data['height'])) {
            $this->setHeight($data['height']);
        }
        if (isset($data['width'])) {
            $this->setWidth($data['width']);
        }
        if (isset($data['length'])) {
            $this->setLength($data['length']);
        }
        $value = $this->calculateValue();
        $this->setValue($value);
    }
}
