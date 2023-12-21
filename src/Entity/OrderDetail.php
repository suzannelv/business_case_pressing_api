<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $orderNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePromo = null;

    #[ORM\Column]
    private ?bool $delivery = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $depositDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $retrieveDate = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PaymentMethod $payment = null;

    #[ORM\OneToMany(mappedBy: 'orderDetail', targetEntity: Product::class)]
    private Collection $product;

    #[ORM\OneToMany(mappedBy: 'orderRelated', targetEntity: ProductDetail::class)]
    private Collection $productDetails;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Staff $staff = null;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->productDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }

    public function setCodePromo(?string $codePromo): static
    {
        $this->codePromo = $codePromo;

        return $this;
    }

    public function isDelivery(): ?bool
    {
        return $this->delivery;
    }

    public function setDelivery(bool $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getDepositDate(): ?\DateTimeInterface
    {
        return $this->depositDate;
    }

    public function setDepositDate(\DateTimeInterface $depositDate): static
    {
        $this->depositDate = $depositDate;

        return $this;
    }

    public function getRetrieveDate(): ?\DateTimeInterface
    {
        return $this->retrieveDate;
    }

    public function setRetrieveDate(\DateTimeInterface $retrieveDate): static
    {
        $this->retrieveDate = $retrieveDate;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(?OrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPayment(): ?PaymentMethod
    {
        return $this->payment;
    }

    public function setPayment(?PaymentMethod $payment): static
    {
        $this->payment = $payment;

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
            $productDetail->setOrderRelated($this);
        }

        return $this;
    }

    public function removeProductDetail(ProductDetail $productDetail): static
    {
        if ($this->productDetails->removeElement($productDetail)) {
            // set the owning side to null (unless already changed)
            if ($productDetail->getOrderRelated() === $this) {
                $productDetail->setOrderRelated(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): static
    {
        $this->staff = $staff;

        return $this;
    }

   
}
