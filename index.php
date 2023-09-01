<?php

/**
 * - Task 7 - 
 * Create a brand new class called Order that has the following properties:
 * 
 * - customerEmail (string)
 * - products (array)
 * 
 * And the following methods:
 * - constructor - this should only accept a customerEmail, not products.
 * - addProduct - Adds any object that inherits from BaseProduct into the products property
 * - processOrder - This method loops through the products property array and calls either the getEmailContent()/getShippingData() methods depending
 * on whether or not the product implements Shippable or Emailable (look up the 'instanceof' operator).
 * Process order should echo out a unordered list for each item displaying the data returned by getEmailContent()/getShippingData()
 */

class Order
{
    protected string $customerEmail;
    protected array $products = [];

    public function __construct(string $customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }

    public function addProduct(BaseProduct $product): void
    {
        $this->products[] = $product;
    }

    public function processOrder(): void
    {
        foreach ($this->products as $product) {
            echo '<ul>';
            if ($product instanceof Shippable) {
                $data = $product->getShippingData();
            } elseif ($product instanceof Emailable) {
                $data = $product->getEmailContent();
            }

            foreach($data as $key => $value) {
                echo "<li>$key: $value</li>";
            }
            echo '</ul>';
        }
    }
}

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

$virtualProd = new VirtualProduct('Thing', 4.99, 'Stuff and things', 'thing', 'pdf', 1);
$physicalProd = new PhysicalProduct('Another thing', 120.00, 'Loads of things', 259);

$order = new Order('john@john.com');
$order->addProduct($virtualProd);
$order->addProduct($physicalProd);

$order->processOrder();