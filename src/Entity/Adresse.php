<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: [
            'groups' => ['get', 'User:item:get'],
        ]),
        new Patch(),
        new GetCollection(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['get']]
)]

class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post', 'User:item:post'])]
    private ?string $ligne1 = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post', 'User:item:post'])]
    private ?string $ligne2 = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post', 'User:item:post'])]
    private ?string $ligne3 = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post', 'User:item:post'])]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post', 'User:item:post'])]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post', 'User:item:post'])]
    private ?string $departement = null;

    #[ORM\OneToMany(mappedBy: 'adresses', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLigne1(): ?string
    {
        return $this->ligne1;
    }

    public function setLigne1(string $ligne1): static
    {
        $this->ligne1 = $ligne1;

        return $this;
    }

    public function getLigne2(): ?string
    {
        return $this->ligne2;
    }

    public function setLigne2(string $ligne2): static
    {
        $this->ligne2 = $ligne2;

        return $this;
    }

    public function getLigne3(): ?string
    {
        return $this->ligne3;
    }

    public function setLigne3(string $ligne3): static
    {
        $this->ligne3 = $ligne3;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): static
    {
        $this->departement = $departement;

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
            $user->setAdresses($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAdresses() === $this) {
                $user->setAdresses(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        // Remplacez les valeurs dans le format qui vous convient
        return "{$this->getLigne1()}, {$this->getLigne2()}, {$this->getLigne3()}, {$this->getCodePostal()} {$this->getVille()}, {$this->getDepartement()}";
    }
}
