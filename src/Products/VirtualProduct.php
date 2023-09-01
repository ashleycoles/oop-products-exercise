<?php

require_once 'src/Interfaces/Emailable.php';
require_once 'src/Products/BaseProduct.php';

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