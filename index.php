<?php

/**
 * - Task 9 -
 * Add namespaces to your new files
 */

use Order\Order;
use Products\PhysicalProduct;
use Products\VirtualProduct;

require_once 'src/Products/VirtualProduct.php';
require_once 'src/Products/PhysicalProduct.php';
require_once 'src/Order/Order.php';

$virtualProd = new VirtualProduct('Thing', 4.99, 'Stuff and things', 'thing', 'pdf', 1);
$physicalProd = new PhysicalProduct('Another thing', 120.00, 'Loads of things', 259);

$order = new Order('john@john.com');
$order->addProduct($virtualProd);
$order->addProduct($physicalProd);

$order->processOrder();
