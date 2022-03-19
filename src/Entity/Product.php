<?php

namespace App\Entity;

use App\Entity\Color;
use App\Entity\Hardware;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product:get-all", "product:get-one"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"product:get-all", "product:get-one"})
     */
    private string $model;

    /**
     * @ORM\Column(type="text")
     * @Groups("product:get-one")
     */
    private string $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product:get-all", "product:get-one"})
     */
    private float $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups("product:get-one")
     */
    private int $stock;

    /**
     * @var Collection<int, Color>
     *
     * Many Products have Many Colors
     * @ORM\ManyToMany(targetEntity=Color::class, inversedBy="products")
     * @JoinTable(name="products_has_color")
     */
    private Collection $colors;

    /**
     * @var Collection<int, Hardware>
     *
     * Many Products have Many Hardware
     * @ORM\ManyToMany(targetEntity=Hardware::class, inversedBy="products")
     * @JoinTable(name="products_has_hardware")
     */
    private Collection $hardwares;

    public function __construct()
    {
        $this->colors    = new ArrayCollection();
        $this->hardwares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    /**
     * @return Collection<int, Color>
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    /**
     * @return Collection<int, Hardware>
     */
    public function getHardwares(): Collection
    {
        return $this->hardwares;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function addColor(Color $color): self
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
        }

        return $this;
    }

    public function addHardware(Hardware $hardware): self
    {
        if (!$this->hardwares->contains($hardware)) {
            $this->hardwares[] = $hardware;
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        $this->colors->removeElement($color);

        return $this;
    }

    public function removeHardware(Hardware $hardware): self
    {
        $this->hardwares->removeElement($hardware);

        return $this;
    }
}
