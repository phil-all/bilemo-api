<?php

namespace App\Entity;

use App\Entity\Shopper;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private string $company;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private float $discountRate;

    /**
     * @var Collection<int, Shopper>
     * @ORM\OneToMany(targetEntity=Shopper::class, mappedBy="client", orphanRemoval=true)
     */
    private Collection $shopper;

    public function __construct()
    {
        $this->shopper = new ArrayCollection();
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

    public function setEmail(string $email): self
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_CLIENT';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(?float $discountRate): self
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    /**
     * @return Collection<int, Shopper>
     */
    public function getShopper(): Collection
    {
        return $this->shopper;
    }

    public function addShopper(Shopper $shopper): self
    {
        if (!$this->shopper->contains($shopper)) {
            $this->shopper[] = $shopper;
            $shopper->setClient($this);
        }

        return $this;
    }

    public function removeShopper(Shopper $shopper): self
    {
        if ($this->shopper->removeElement($shopper)) {
            // set the owning side to null (unless already changed)
            if ($shopper->getClient() === $this) {
                $shopper->setClient(null);
            }
        }

        return $this;
    }

    /**
     * Creates a new instance from a given JWT payload.
     *
     * @param string $id
     *
     * @return JWTUserInterface
     */
    public static function createFromPayload($id, array $payload): JWTUserInterface
    {
        $payload = null; // dead code needed to use $payload to avoid phpmd issue on unused variables.

        return (new Client())->setId(intval($id));
    }
}
