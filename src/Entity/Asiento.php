<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\Base;
use App\Repository\AsientoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AsientoRepository::class)]
#[ApiResource]
class Asiento extends Base {

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $numero = null;

    #[ORM\ManyToOne(inversedBy: 'asientos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bus $bus = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $clase = null;


    public function getNumero(): ?int {
        return $this->numero;
    }

    public function setNumero(int $numero): static {
        $this->numero = $numero;

        return $this;
    }

    public function getBus(): ?Bus {
        return $this->bus;
    }

    public function setBus(?Bus $bus): static {
        $this->bus = $bus;

        return $this;
    }

    public function getClase(): ?string {
        return $this->clase;
    }

    public function setClase(?string $clase): static {
        $this->clase = $clase;

        return $this;
    }
}
