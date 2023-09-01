<?php

namespace Products;

use Interfaces\Shippable;

require_once 'src/Interfaces/Shippable.php';
require_once 'src/Products/BaseProduct.php';

class PhysicalProduct extends BaseProduct implements Shippable
{
    protected float $weight;

    public function __construct(string $name, float $price, string $description, float $weight = 0)
    {
        if ($weight < 0) {
            throw new \Exception('Error: Weight must be above 0');
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
