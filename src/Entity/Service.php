<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $priceCoefficent = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ProductDetail::class)]
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

    public function getPriceCoefficent(): ?float
    {
        return $this->priceCoefficent;
    }

    public function setPriceCoefficent(float $priceCoefficent): static
    {
        $this->priceCoefficent = $priceCoefficent;

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
            $productDetail->setService($this);
        }

        return $this;
    }

    public function removeProductDetail(ProductDetail $productDetail): static
    {
        if ($this->productDetails->removeElement($productDetail)) {
            // set the owning side to null (unless already changed)
            if ($productDetail->getService() === $this) {
                $productDetail->setService(null);
            }
        }

        return $this;
    }
}
