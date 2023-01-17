<?php

namespace App\Entity;

use App\Entity\Trait\HasTimestamps;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('`printing_model`')]
#[HasLifecycleCallbacks]
class PrintingModel
{
    use HasTimestamps;

    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'stl_filename')]
    private string $filename;

    #[Column(name: 'user_filename')]
    private string $original_name;

    #[Column(name: 'material_cost', type: 'decimal', precision: 10, scale: 2)]
    private float $materialCost;

    #[Column(name: 'price', type: 'decimal', precision: 10, scale: 2)]
    private float $price;


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PrintingModel
     */
    public function setId(int $id): PrintingModel
    {
        $this->id = $id;
        return $this;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return PrintingModel
     */
    public function setFilename(string $filename): PrintingModel
    {
        $this->filename = $filename;
        return $this;
    }

    public function getMaterialCost(): float
    {
        return $this->materialCost;
    }

    /**
     * @param int $materialCost
     * @return PrintingModel
     */
    public function setMaterialCost(float $materialCost): PrintingModel
    {
        $this->materialCost = $materialCost;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->original_name;
    }

    public function setOriginalName($original_name)
    {
        $this->original_name = $original_name;
        return $this;
    }

}
