<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;


#[Entity]
#[Table('`shopping_cart_items`')]
class ShoppingCartItem
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

//    #[Column(name: 'printing_model_id')]
    #[ManyToOne(targetEntity:PrintingModel::class)]
    #[JoinColumn(name:"printing_model_id", referencedColumnName:"id")]
    private $printingModel;

    #[Column(name: 'quantity', type: 'decimal', precision: 10, scale: 2)]
    private int $quantity;

    #[ManyToOne(cascade: ['persist'], inversedBy: 'shoppingCardItems')]
    private User $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): ShoppingCartItem
    {
        $this->id = $id;
        return $this;
    }

    public function getPrintingModel(): PrintingModel
    {
        return $this->printingModel;
    }

    public function setPrintingModel($printingModel): ShoppingCartItem
    {
        $this->printingModel = $printingModel;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): ShoppingCartItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): ShoppingCartItem
    {
        $user->addShoppingCardItem($this);

        $this->user = $user;
        return $this;
    }

}
