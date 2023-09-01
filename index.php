<?php

/**
 * - Task 4 - 
 * You'll notice that the BaseProduct has an abstract method called calculateShippingCost that is currently commented out. Uncomment the abstract
 * method and implement it in both the PhysicalProduct and the VirtualProduct.
 * 
 * For the PhysicalProduct, the shipping cost is calculated like so:
 * 
 * If the weight of the product is above or equal to 10, the shipping cost is 10.5
 * If the weight of the product is less than 10, the shipping cost is 2.95
 * However, if the price of the product is above 100, then the shipping cost is 0
 * 
 * For the VitualProduct, the shipping cost is calculated like so:
 * 
 * If the fileSize is greater than or equal to 100, the shipping cost is 0.5
 * Otherwise the shipping cost of a VirtualProduct is 0
 */

abstract class BaseProduct
{
    protected string $name;
    protected float $price;
    protected string $description;

    public function __construct(string $name, float $price, string $description)
    {
        if ($price < 0) {
            throw new Exception('Error: Price must be above 0');
        }

        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public abstract function calculateShippingCost(): float;

}

class PhysicalProduct extends BaseProduct
{
    protected float $weight;

    public function __construct(string $name, float $price, string $description, float $weight = 0)
    {
        if ($weight < 0) {
            throw new Exception('Error: Weight must be above 0');
        }

        $this->weight = $weight;
        parent::__construct($name, $price, $description); // Calling the constructor of the parent
    }

    public function calculateShippingCost(): float
    {
        if ($this->price > 100) {
            return 0.0;
        }

        if ($this->weight >= 10) {
            return 10.5;
        }

        return 2.95;
    }
}

class VirtualProduct extends BaseProduct
{
    protected string $fileName;
    protected string $fileType;
    protected float $fileSize;

    public function __construct(string $name, float $price, string $description, string $fileName, string $fileType, float $fileSize)
    {
        if ($fileSize < 0) {
            throw new Exception('Error: File size must be above 0');
        }
        
        $this->fileName = $fileName;
        $this->fileType = $fileType;
        $this->fileSize = $fileSize;
        parent::__construct($name, $price, $description); 
    }

    public function calculateShippingCost(): float
    {
        if ($this->fileSize >= 100) {
            return 0.5;
        }

        return 0.0;
    }
}

interface Emailable
{
    public function getEmailContent(): array;
}

interface Shippable
{
    public function getShippingData(): array;
}

