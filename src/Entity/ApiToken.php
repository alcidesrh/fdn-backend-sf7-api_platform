<?php

namespace App\Entity;

use App\Entity\Base\Base;
use App\Entity\Base\TimestampableEntity;
use App\Repository\ApiTokenRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ApiTokenRepository::class)]
class ApiToken extends Base {
    use TimestampableEntity;

    private const PERSONAL_ACCESS_TOKEN_PREFIX = 'fdn_';

    public const SCOPE_USER_EDIT = 'ROLE_USER_EDIT';
    public const SCOPE_TREASURE_CREATE = 'ROLE_TREASURE_CREATE';
    public const SCOPE_TREASURE_EDIT = 'ROLE_TREASURE_EDIT';

    public const SCOPES = [
        self::SCOPE_USER_EDIT => 'Edit User',
        self::SCOPE_TREASURE_CREATE => 'Create Treasures',
        self::SCOPE_TREASURE_EDIT => 'Edit Treasures',
    ];

    #[ORM\ManyToOne(inversedBy: 'apiTokens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expira = null;

    #[ORM\Column(length: 68)]
    private string $token;

    #[ORM\Column]
    private array $scopes = [];

    #[ORM\Column(nullable: true)]
    private ?bool $activo = null;

    public function __construct(string $tokenType = self::PERSONAL_ACCESS_TOKEN_PREFIX) {
        $this->token = $tokenType . bin2hex(random_bytes(32));
    }


    public function getUsuario(): ?User {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self {
        $this->usuario = $usuario;

        return $this;
    }

    public function getExpira(): ?\DateTimeImmutable {
        return $this->expira;
    }

    public function setExpira(?\DateTimeImmutable $expira): self {
        $this->expira = $expira;

        return $this;
    }

    public function getToken(): ?string {
        return $this->token;
    }

    public function setToken(string $token): self {
        $this->token = $token;

        return $this;
    }

    public function getScopes(): array {
        return $this->scopes;
    }

    public function setScopes(array $scopes): self {
        $this->scopes = $scopes;

        return $this;
    }

    public function isValid(): bool {
        return $this->expira === null || $this->expira > new \DateTimeImmutable() || $this->isActivo();
    }

    public function isActivo(): ?bool {
        return $this->activo;
    }

    public function setActivo(?bool $activo): static {
        $this->activo = $activo;

        return $this;
    }
}
