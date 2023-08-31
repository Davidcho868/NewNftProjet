<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCategorie = null;

    #[ORM\ManyToMany(targetEntity: Nft::class, mappedBy: 'categories')]
    private Collection $Nfts;

    public function __construct()
    {
        $this->Nfts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Nft>
     */
    public function getNfts(): Collection
    {
        return $this->Nfts;
    }

    public function addNFT(Nft $Nft): static
    {
        if (!$this->Nfts->contains($Nft)) {
            $this->Nfts->add($Nft);
            $Nft->addCategory($this);
        }

        return $this;
    }

    public function removeNFT(Nft $Nft): static
    {
        if ($this->Nfts->removeElement($Nft)) {
            $Nft->removeCategory($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNomCategorie();
    }
}
