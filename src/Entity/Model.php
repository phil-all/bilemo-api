<?php

namespace App\Entity;

use App\Entity\Size;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ModelRepository;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"product:get-all", "product:get-one"})
     */
    private string $designation;

    /**
     * @ORM\Column(type="text")
     * @Groups({"product:get-one"})
     */
    private string $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product:get-all", "product:get-one"})
     */
    private float $price;

    /**
     * @ORM\ManyToOne(targetEntity=Size::class, inversedBy="models")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product:get-one"})
     */
    private Size $size;

    /**
     * @var Collection<int, Product>
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="model", orphanRemoval=true)
     */
    private Collection $products;

    /**
     * @var Collection<int, Option>
     *
     * Many Models have Many Options
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="Models")
     * @JoinTable(name="Model_has_Option")
     * @Groups({"product:get-one"})
     */
    private Collection $options;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->options  = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

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

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setModel($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getModel() === $this) {
                $product->setModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }


    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }
}
