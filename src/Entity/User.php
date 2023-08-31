<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: [
            'groups' => ['get', 'User:item:get'],
        ]),
        new Patch(),
        new GetCollection(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['get','post']],
    denormalizationContext: ['groups' => ['post', 'User:item:post']]
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['get','post'])]
    #[Assert\Email]
    #[Assert\NotBlank]
    private ?string $email = null;

    #[ORM\Column]
    
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    protected ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get','post'])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['get','post'])]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column]
    #[Groups(['get','post'])]
    private ?bool $isProprietaire = null;

    #[ORM\ManyToOne(inversedBy: 'users', targetEntity: Adresse::class, cascade: ['persist'])]
    #[Groups(['User:item:post', 'user:item:get'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adresse $adresses = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Nft::class)]
    #[Groups(['user:item:get', 'User:item:post' ])]
    private Collection $nfts;

    public function __construct()
    {
        $this->nfts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Méthode getUsername qui permet de retourner le champs qui est utilisé pour l'authentification
     * 
     * @return string
     * */
    public function getUsername() :string {
        return  $this -> getUserIdentifier() ;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function isIsProprietaire(): ?bool
    {
        return $this->isProprietaire;
    }

    public function setIsProprietaire(bool $isProprietaire): static
    {
        $this->isProprietaire = $isProprietaire;

        return $this;
    }

    public function getAdresses(): ?Adresse
    {
        return $this->adresses;
    }

    public function setAdresses(?Adresse $adresses): static
    {
        $this->adresses = $adresses;

        return $this;
    }

    

	/**
	 * @return 
	 */
	public function getPlainPassword(): ?string {
                return $this->plainPassword;
    	}
	
	/**
	 * @param  $plainPassword 
	 * @return self
	 */
	public function setPlainPassword(?string $plainPassword): self {
                $this->plainPassword = $plainPassword;
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
            $nft->setUser($this);
        }

        return $this;
    }

    public function removeNft(Nft $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getUser() === $this) {
                $nft->setUser(null);
            }
        }

        return $this;
    }

    
    public static function createFromPayload($username, array $payload): self
    {
        return (new self())
            ->setId($username)
            ->setRoles($payload['roles'])
            ->setEmail($payload['email'])
        ;
    }


}
