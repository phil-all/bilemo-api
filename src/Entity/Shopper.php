<?php

namespace App\Entity;

use App\Entity\Client;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ShopperRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ShopperRepository::class)
 *
 * @OA\Schema()
 */
class Shopper
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"shopper:get-all", "get-one"})
     *
     * @OA\Property()
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"shopper:get-all", "get-one"})
     *
     * @OA\Property()
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups("get-one")
     *
     * @OA\Property()
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups("get-one")
     *
     * @OA\Property()
     */
    private string $lastName;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="shopper")
     * @ORM\JoinColumn(nullable=false)
     */
    private Client $client;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
