<?php

namespace App\Entity;

use App\Repository\ZipCodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZipCodeRepository::class)]
class ZipCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $zc = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\ManyToOne(inversedBy: 'zipCodes')]
    private ?Country $country = null;

    #[ORM\OneToMany(mappedBy: 'zc', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'zc', targetEntity: Staff::class)]
    private Collection $staff;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->staff = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZc(): ?string
    {
        return $this->zc;
    }

    public function setZc(string $zc): static
    {
        $this->zc = $zc;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setZc($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getZc() === $this) {
                $user->setZc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): static
    {
        if (!$this->staff->contains($staff)) {
            $this->staff->add($staff);
            $staff->setZc($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): static
    {
        if ($this->staff->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getZc() === $this) {
                $staff->setZc(null);
            }
        }

        return $this;
    }
}
