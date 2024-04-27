<?php

namespace App\Entity;

use App\Attribute\FormCreateExclude;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\UserBase;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User extends UserBase implements UserInterface, PasswordAuthenticatedUserInterface {
    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: ApiToken::class)]
    private Collection $apiTokens;

    private ?array $accessTokenScopes = null;

    #[ORM\ManyToMany(targetEntity: Permiso::class, mappedBy: 'usuarios')]
    private Collection $permisos;
    public function __construct(string $userIdentifier = '', array $roles = []) {

        $this->username = $userIdentifier;
        $this->roles = $roles;
        $this->apiTokens = new ArrayCollection();
        $this->permisos = new ArrayCollection();
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): static {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    #[FormCreateExclude]
    public function getUserIdentifier(): string {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        if (null === $this->accessTokenScopes) {
            // logged in via the full user mechanism
            $roles = $this->roles;
            $roles[] = 'ROLE_FULL_USER';
        } else {
            $roles = $this->accessTokenScopes;
        }
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): static {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }



    // public static function createFromPayload($username, array $payload): User {
    //     return new self(
    //         $username,
    //         $payload['roles'] ?? [], // Added by default
    //         $payload['username'] ?? [] // Custom
    //     );
    // }

    public function __toString() {
        return $this->username;
    }

    /**
     * @return Collection<int, ApiToken>
     */
    public function getApiTokens(): Collection {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): static {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens->add($apiToken);
            $apiToken->setUsuario($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): static {
        if ($this->apiTokens->removeElement($apiToken)) {
            // set the owning side to null (unless already changed)
            if ($apiToken->getUsuario() === $this) {
                $apiToken->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getValidTokenStrings(): array {
        return $this->getApiTokens()
            ->filter(fn (ApiToken $token) => $token->isValid())
            ->map(fn (ApiToken $token) => $token->getToken())
            ->toArray();
    }
    public function markAsTokenAuthenticated(array $scopes) {
        $this->accessTokenScopes = $scopes;
    }

    /**
     * @return Collection<int, Permiso>
     */
    public function getPermisos(): Collection {
        return $this->permisos;
    }

    public function addPermiso(Permiso $permiso): static {
        if (!$this->permisos->contains($permiso)) {
            $this->permisos->add($permiso);
            $permiso->addUsuario($this);
        }

        return $this;
    }

    public function removePermiso(Permiso $permiso): static {
        if ($this->permisos->removeElement($permiso)) {
            $permiso->removeUsuario($this);
        }

        return $this;
    }
}
