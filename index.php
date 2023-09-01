<?php

/**
 * - Task 3 - 
 * The VirtualProduct is missing it's constructor entirely, please add one in.
 * 
 * As part of this, please add a check to make sure the fileSize is above 0, also throwing an exception if it's not. The exception should have the message
 * 'Error: File size must be above 0'
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

    public function __construct(string $name, float $price, string $description, float $weight = 0)
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
}

interface Emailable
{
    public function getEmailContent(): array;
}

interface Shippable
{
    public function getShippingData(): array;
}

