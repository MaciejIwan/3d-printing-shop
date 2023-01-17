<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contracts\UserInterface;
use App\Entity\Trait\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table('users')]
#[HasLifecycleCallbacks]
class User implements UserInterface
{
    use HasTimestamps;

    #[Id, Column(options: ['unsigned' => true]), GeneratedValue]
    private int $id;

    #[Column]
    private string $name;

    #[Column(unique: true)]
    private string $email;

    #[Column]
    private string $password;

    #[OneToMany(mappedBy: 'user', targetEntity: ShoppingCartItem::class)]
    private Collection $shoppingCardItems;

    public function __construct()
    {
        $this->shoppingCardItems = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function getShoppingCardItems(): ArrayCollection|Collection
    {
        return $this->shoppingCardItems;
    }

    public function addShoppingCardItem(ShoppingCartItem $item): User
    {
        $this->shoppingCardItems->add($item);

        return $this;
    }
}
