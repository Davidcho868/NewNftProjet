<?php

namespace App\Entity;

use App\Repository\EthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EthRepository::class)]
class Eth
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $coursEth = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $jourDuCours = null;

    #[ORM\OneToMany(mappedBy: 'eth', targetEntity: Nft::class)]
    private Collection $nfts;

    public function __construct()
    {
        $this->nfts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoursEth(): ?float
    {
        return $this->coursEth;
    }

    public function setCoursEth(float $coursEth): static
    {
        $this->coursEth = $coursEth;

        return $this;
    }

    public function getJourDuCours(): ?\DateTimeInterface
    {
        return $this->jourDuCours;
    }

    public function setJourDuCours(\DateTimeInterface $jourDuCours): static
    {
        $this->jourDuCours = $jourDuCours;

        return $this;
    }

    /**
     * @return Collection<int, Nft>
     */
    public function getNfts(): Collection
    {
        return $this->nfts;
    }

    public function addNft(Nft $nft): static
    {
        if (!$this->nfts->contains($nft)) {
            $this->nfts->add($nft);
            $nft->setEth($this);
        }

        return $this;
    }

    public function removeNft(Nft $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getEth() === $this) {
                $nft->setEth(null);
            }
        }

        return $this;
    }
}
