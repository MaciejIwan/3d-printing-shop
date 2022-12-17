<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;


#[Entity]
#[Table('`user`')]
class User
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'password_hash')]
    private string $paaswordHash;

    //todo email must be uniq
    #[Column(name: 'email')]
    private string $email;


    #[OneToMany(mappedBy: '`user`', targetEntity: UserAddress::class, cascade: ['persist', 'remove'])]
    private Collection $addresses;

    public function addAddress(UserAddress $address)
    {
        $address->setUser($this);
        $this->addresses->add($address);
        return $this;
    }

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
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

    public function getPaaswordHash(): string
    {
        return $this->paaswordHash;
    }

    /**
     * @param string $paaswordHash
     * @return User
     */
    public function setPaaswordHash(string $paaswordHash): User
    {
        $this->paaswordHash = $paaswordHash;
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