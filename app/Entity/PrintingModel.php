<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;

//#[Setter, Getter]
#[Entity]
#[Table('`printing_model`')]
#[HasLifecycleCallbacks]
class PrintingModel
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;


    #[Column(name: 'stl_filename')]
    private string $filename;

    #[Column(name: 'material_cost', type: 'decimal', precision: 10, scale: 2)]
    private int $materialCost;

    #[Column(name: 'created_at')]
    private DateTime $createdAt;

    #[Column(name: 'updated_at')]
    private DateTime $updatedAt;

    #[PrePersist, PreUpdate]
    public function updateTimestamps(LifecycleEventArgs $args): void
    {
        if (!isset($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        $this->updatedAt = new DateTime();
    }


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

    public function getModelId(): int
    {
        return $this->modelId;
    }

    /**
     * @param int $modelId
     * @return PrintingModel
     */
    public function setModelId(int $modelId): PrintingModel
    {
        $this->modelId = $modelId;
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

    public function getMaterialCost(): int
    {
        return $this->materialCost;
    }

    /**
     * @param int $materialCost
     * @return PrintingModel
     */
    public function setMaterialCost(int $materialCost): PrintingModel
    {
        $this->materialCost = $materialCost;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return PrintingModel
     */
    public function setCreatedAt(DateTime $createdAt): PrintingModel
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return PrintingModel
     */
    public function setUpdatedAt(DateTime $updatedAt): PrintingModel
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}