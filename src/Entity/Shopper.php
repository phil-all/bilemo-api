<?php

namespace App\Entity;

use App\Entity\Client;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ShopperRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ShopperRepository::class)
 */
class Shopper
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user:get-one")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:get-one")
     */
    private string $email;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="shopper")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("user:get-one")
     */
    private Client $client;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups("user:get-one")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups("user:get-one")
     */
    private string $lastName;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("user:get-one")
     */
    private DateTimeImmutable $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
