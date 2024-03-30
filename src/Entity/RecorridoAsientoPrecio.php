<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RecorridoAsientoPrecioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecorridoAsientoPrecioRepository::class)]
#[ApiResource]
class RecorridoAsientoPrecio {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recorrido $recorrido = null;

    #[ORM\Column(nullable: true)]
    private ?float $precioAsientoA = null;

    #[ORM\Column(nullable: true)]
    private ?float $precioAsientoB = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getRecorrido(): ?Recorrido {
        return $this->recorrido;
    }

    public function setRecorrido(?Recorrido $recorrido): static {
        $this->recorrido = $recorrido;

        return $this;
    }

    public function getPrecioAsientoA(): ?float {
        return $this->precioAsientoA;
    }

    public function setPrecioAsientoA(?float $precioAsientoA): static {
        $this->precioAsientoA = $precioAsientoA;

        return $this;
    }

    public function getPrecioAsientoB(): ?float {
        return $this->precioAsientoB;
    }

    public function setPrecioAsientoB(?float $precioAsientoB): static {
        $this->precioAsientoB = $precioAsientoB;

        return $this;
    }
}
