<?php

/**
 * Incomplete OOP products excercise
 * 
 * Welcome to ACME dev company. Your first task is to pick up where your colleage, Chip Morningstar, left off with some code for our new online store. Unfortuntaly Chip 
 * is off sick and can't finish his work.
 * 
 * - Task 1 -
 * Chip didn't have any time to comment the code, so your first task
 * is to simply go through the code and make sure you understand it all, adding comments where you feel they are appropriate (which could be every line)
 * 
 * Please also make sure to add comments as you go with the other tasks.
 * 
 * 
 * - Task 2 -
 * The construct method of the PhysicalProduct class should have a basic check on the weight before it gets saved to the weight property. 
 * If the weight is less than 0, throw an exception with the message 'Error: Weight must be above 0'
 * 
 * 
 * - Task 3 - 
 * The VirtualProduct is missing it's constructor entirely, please add one in.
 * 
 * As part of this, please add a check to make sure the fileSize is above 0, also throwing an exception if it's not. The exception should have the message
 * 'Error: File size must be above 0'
 * 
 * 
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
 * 
 * 
 * - Task 5 - 
 * You'll notice there is an interface called Emailable that is currently not being used.
 * 
 * Implement this interface in the VirtualProduct class, and add the required method.
 * 
 * The idea behind this method is that it returns the VirtualProduct data needed for another (non existent) object
 * to send the product to the customer via email
 * 
 * The method should return an assoc array with the following keys/values:
 * 1) A key of 'name' containing the name of the product
 * 2) A key called 'description' containing the description of the product
 * 3) A key called 'file' containing the fileName + the fileType (for example test.pdf) 
 * 
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
 * 3) A key called 'weight' containing the weight of the product
 * 
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
 * 
 * - Task 8 -
 * There is a lot of code in this file now, time to tidy up and move each class/interface into their own file
 * 
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

