<?php

/**

 * - Task 2 -
 * The construct method of the PhysicalProduct class should have a basic check on the weight before it gets saved to the weight property. 
 * If the weight is less than 0, throw an exception with the message 'Error: Weight must be above 0'
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

    // public abstract function calculateShippingCost(): float;

}

class PhysicalProduct extends BaseProduct
{
    protected float $weight;

    public function __construct(string $name, float $price, string $description, $weight = 0)
    {
        if ($weight < 0) {
            throw new Exception('Error: Weight must be above 0');
        }

        $this->weight = $weight;
        parent::__construct($name, $price, $description); // Calling the constructor of the parent
    }
}

class VirtualProduct extends BaseProduct
{
    protected string $fileName;
    protected string $fileType;
    protected float $fileSize;
}

interface Emailable
{
    public function getEmailContent(): array;
}

interface Shippable
{
    public function getShippingData(): array;
}

