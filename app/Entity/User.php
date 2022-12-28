<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contracts\UserInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;


#[Entity, Table('`user`')]
#[HasLifecycleCallbacks]
class User implements UserInterface
{
    #[Id, Column(options: ['unsigned' => true]), GeneratedValue]
    private int $id;

    #[Column(name: 'name')]
    private string $name;

    #[Column(name: 'email', unique: true, nullable: false)]
    private string $email;

    #[Column(name: 'password_hash', nullable: false)]
    private string $passwordHash;

    #[OneToMany(mappedBy: '`user`', targetEntity: UserAddress::class, cascade: ['persist', 'remove'])]
    private Collection $addresses;

    #[Column(name: 'created_at')]
    private \DateTime $createdAt;

    #[Column(name: 'updated_at')]
    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    public function addAddress(UserAddress $address)
    {
        $address->setUser($this);
        $this->addresses->add($address);
        return $this;
    }

    #[PrePersist, PreUpdate]
    public function updateTimestamps(LifecycleEventArgs $args): void
    {
        if (!isset($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        $this->updatedAt = new DateTime();
    }



    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     * @return User
     */
    public function setPasswordHash(string $passwordHash): User
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Collection $addresses
     * @return User
     */
    public function setAddresses(Collection $addresses): User
    {
        $this->addresses = $addresses;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

}