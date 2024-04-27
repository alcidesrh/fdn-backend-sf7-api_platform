<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\Base;
use App\Repository\PaisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaisRepository::class)]
#[ApiResource]
class Pais extends Base {

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static {
        $this->nombre = $nombre;

        return $this;
    }
}
