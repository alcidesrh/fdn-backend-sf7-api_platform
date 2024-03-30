<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\LogBase;
use App\Repository\SalidaLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalidaLogRepository::class)]
#[ApiResource]
class SalidaLog extends LogBase {

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tipo = null;

    #[ORM\ManyToOne(inversedBy: 'salidaLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salida $salida = null;

    public function getTipo(): ?string {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): static {
        $this->tipo = $tipo;

        return $this;
    }


    public function getSalida(): ?Salida {
        return $this->salida;
    }

    public function setSalida(?Salida $salida): static {
        $this->salida = $salida;

        return $this;
    }
}
