<?php

namespace Order;

use Interfaces\Emailable;
use Interfaces\Shippable;
use Products\BaseProduct;

require_once 'src/Products/BaseProduct.php';
require_once 'src/Interfaces/Emailable.php';
require_once 'src/Interfaces/Shippable.php';

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
