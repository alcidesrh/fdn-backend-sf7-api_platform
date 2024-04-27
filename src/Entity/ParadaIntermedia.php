<?php

namespace App\Entity;

use App\Entity\Base\Base;
use App\Repository\ParadaIntermediaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParadaIntermediaRepository::class)]
class ParadaIntermedia extends Base {

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parada $parada = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $posicion = null;

    #[ORM\ManyToOne(inversedBy: 'paradas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recorrido $recorrido = null;


    public function getParada(): ?Parada {
        return $this->parada;
    }

    public function setParada(?Parada $parada): static {
        $this->parada = $parada;

        return $this;
    }
    public function getPosicion(): ?int {
        return $this->posicion;
    }

    public function setPosicion(?int $posicion): static {
        $this->posicion = $posicion;

        return $this;
    }

    public function getRecorrido(): ?Recorrido {
        return $this->recorrido;
    }

    public function setRecorrido(?Recorrido $recorrido): static {
        $this->recorrido = $recorrido;

        return $this;
    }
}
