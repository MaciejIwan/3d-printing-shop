<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('`user_address`')]
class UserAddress
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'user_id')]
    private int $userId;

    #[Column(name: 'phone_number')]
    private string $phoneNumber;

    #[Column(name: 'country', type: Types::STRING, nullable: true)]
    private string $country = "";
    #[Column(name: 'post_code', type: Types::STRING, nullable: true)]
    private string $postCode;

    #[Column(name: 'city', type: Types::STRING, nullable: true)]
    private string $city;

    #[Column(name: 'street', type: Types::STRING, nullable: true)]
    private string $street;

    #[Column(name: 'direction', type: Types::STRING, nullable: true)]
    private string $direction;

    #[Column(name: 'created_at', type: "datetime", nullable: true)]
    private DateTime $createdAt;

    #[Column(name: 'updated_at', type: "datetime", nullable: true)]
    private DateTime $updatedAt;

    #[ManyToOne(cascade: ['persist'], inversedBy: 'addresses')]
    private User $user;


    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }


    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): UserAddress
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserAddress
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): UserAddress
    {
        $this->userId = $userId;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): UserAddress
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): UserAddress
    {
        $this->country = $country;
        return $this;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): UserAddress
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): UserAddress
    {
        $this->city = $city;
        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): UserAddress
    {
        $this->street = $street;
        return $this;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): UserAddress
    {
        $this->direction = $direction;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): UserAddress
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): UserAddress
    {
        $this->user = $user;
        return $this;
    }


}