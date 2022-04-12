<?php

namespace App\Entity;

use App\Entity\Color;
use App\Entity\Model;
use OpenApi\Annotations as OA;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 *
 * @OA\Schema()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product:get-all", "product:get-one"})
     *
     * @OA\Property(example="5")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=13)
     * @Groups({"product:get-one"})
     *
     * @OA\Property(example="0440710192709")
     */
    private string $ean13;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"product:get-all", "product:get-one"})
     *
     * @OA\Property(example="344")
     */
    private int $stock;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product:get-all", "product:get-one"})
     *
     * @OA\Property(
     *   example={
     *      "designation": "B-950 Xserie",
     *      "description": "Nouveau B-950 Xserie, Processeur Qualcomm Snapdragon 680 - 4 Go de RAM - 64 Go de ROM.",
     *      "price": 1370,
     *      "size": {"size": 7.3}
     *   }
     * )
     */
    private Model $model;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product:get-all", "product:get-one"})
     *
     * @OA\Property(example="maroon")
     */
    private Color $color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEan13(): ?string
    {
        return $this->ean13;
    }

    public function setEan13(string $ean13): self
    {
        $this->ean13 = $ean13;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }
}
