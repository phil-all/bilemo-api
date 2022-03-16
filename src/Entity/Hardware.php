<?php

namespace App\Entity;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HardwareRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=HardwareRepository::class)
 */
class Hardware
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private string $name;
    /**
     * @var Collection<int, Product>
     *
     * Many Options have Many Products
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="hardware")
     */
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addHardware($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeHardware($this);
        }

        return $this;
    }
}
