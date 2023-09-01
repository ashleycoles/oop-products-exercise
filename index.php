<?php

/**
 * - Task 6 - 
 * There is also an interface called Shippable that is currently unused.
 * 
 * Implement the interface in the PhysicalProduct class, and add the required method.
 * 
 * The idea behind this method is that it returns the PhysicalProduct data for another (non existent) object
 * that is in charge of arranging delivery of the product.
 * 
 * The method should return an assoc array with the following keys/values:
 * 1) A key of 'name' containing the name of the product
 * 2) A key called 'description' containing the description of the product
 * 3) A key called 'shippingCost' containing the shipping cost of the product 
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

class PhysicalProduct extends BaseProduct implements Shippable
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

    public function getShippingData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'shippingCost' => $this->calculateShippingCost()
        ];
    }
}

class VirtualProduct extends BaseProduct implements Emailable
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

    public function getEmailContent(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'file' => $this->fileName . '.' . $this->fileType
        ];
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

