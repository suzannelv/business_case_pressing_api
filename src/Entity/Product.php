<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductDetail::class)]
    private Collection $productDetails;

    public function __construct()
    {
        $this->productDetails = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ProductDetail>
     */
    public function getProductDetails(): Collection
    {
        return $this->productDetails;
    }

    public function addProductDetail(ProductDetail $productDetail): static
    {
        if (!$this->productDetails->contains($productDetail)) {
            $this->productDetails->add($productDetail);
            $productDetail->setProduct($this);
        }

        return $this;
    }

    public function removeProductDetail(ProductDetail $productDetail): static
    {
        if ($this->productDetails->removeElement($productDetail)) {
            // set the owning side to null (unless already changed)
            if ($productDetail->getProduct() === $this) {
                $productDetail->setProduct(null);
            }
        }

        return $this;
    }

 
}
