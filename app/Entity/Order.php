<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\HasTimestamps;
use App\Enum\OrderStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;


#[Entity, Table('`order`'), HasLifecycleCallbacks]
class Order
{
    use HasTimestamps;

    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column]
    private string $name;

    #[Column(type: 'decimal', scale: 2)]
    private float $total;

    #[Column(enumType: OrderStatus::class)]
    private OrderStatus $status;

    #[ManyToOne(inversedBy: 'order')]
    private User $user;


    #[OneToMany(mappedBy: 'order', targetEntity: OrderItem::class, cascade: ['persist', 'remove'])]
    private Collection $items;

    #[Column(name: "payment_id", nullable: true)]
    private string $paymentId;

    #[Column]
    private bool $paid;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->paid = false;
    }

    public function addItem(OrderItem $item): Order
    {
        $item->setOrder($this);
        $this->items->add($item);
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): Order
    {
        $this->name = $name;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): Order
    {
        $this->total = $total;
        return $this;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus($status): Order
    {
        $this->status = $status;
        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Order
    {
        $this->user = $user;
        return $this;
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): Order
    {
        $this->paid = $paid;
        return $this;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function setPaymentId(string $paymentId): Order
    {
        $this->paymentId = $paymentId;
        return $this;
    }

}
