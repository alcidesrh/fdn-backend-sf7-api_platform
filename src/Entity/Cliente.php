<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\PersonaBase;
use App\Repository\ClienteRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
#[ApiResource]
class Cliente extends PersonaBase {

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $dpi = null;
    public function getDpi(): ?string {
        return $this->dpi;
    }

    public function setDpi(?string $dpi): static {
        $this->dpi = $dpi;

        return $this;
    }
}
