<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: NftRepository::class)]
#[ApiResource]
class Nft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $valeurEuro = null;

    #[ORM\Column]
    private ?float $prixEth = null;

    #[ORM\Column]
    private ?bool $isEnVente = null;


    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'Nfts')]
    private Collection $categories;

    

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    private ?Eth $eth = null;

    #[ORM\OneToOne(inversedBy: 'nft', cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    private ?User $user = null;

    public function __construct()
    {

        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurEuro(): ?float
    {
        return $this->valeurEuro;
    }

    public function setValeurEuro(float $valeurEuro): static
    {
        $this->valeurEuro = $valeurEuro;

        return $this;
    }

    public function getPrixEth(): ?float
    {
        return $this->prixEth;
    }

    public function setPrixEth(float $prixEth): static
    {
        $this->prixEth = $prixEth;

        return $this;
    }

    public function isIsEnVente(): ?bool
    {
        return $this->isEnVente;
    }

    public function setIsEnVente(bool $isEnVente): static
    {
        $this->isEnVente = $isEnVente;

        return $this;
    }



    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $categorie): static
    {
        if (!$this->categories->contains($categorie)) {
            $this->categories->add($categorie);
        }

        return $this;
    }

    public function removeCategory(Categorie $categorie): static
    {
        $this->categories->removeElement($categorie);

        return $this;
    }



    public function getEth(): ?Eth
    {
        return $this->eth;
    }

    public function setEth(?Eth $eth): static
    {
        $this->eth = $eth;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

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
}
