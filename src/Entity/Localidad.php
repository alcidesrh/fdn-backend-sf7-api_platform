<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LocalidadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalidadRepository::class)]
#[ApiResource]
class Localidad {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToOne]
    private ?Pais $pais = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPais(): ?Pais {
        return $this->pais;
    }

    public function setPais(?Pais $pais): static {
        $this->pais = $pais;

        return $this;
    }
}
