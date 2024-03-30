<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\TimeStatusBase;
use App\Repository\FacturaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
#[ApiResource]
class Factura extends TimeStatusBase {


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dte = null;

    #[ORM\Column(type: Types::GUID, nullable: true)]
    private ?string $uuid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $serie = null;

    #[ORM\OneToOne(mappedBy: 'factura', cascade: ['persist', 'remove'])]
    private ?Venta $venta = null;

    public function getDte(): ?string {
        return $this->dte;
    }

    public function setDte(?string $dte): static {
        $this->dte = $dte;

        return $this;
    }

    public function getUuid(): ?string {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): static {
        $this->uuid = $uuid;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): static {
        $this->fecha = $fecha;

        return $this;
    }

    public function getSerie(): ?string {
        return $this->serie;
    }

    public function setSerie(?string $serie): static {
        $this->serie = $serie;

        return $this;
    }

    public function getVenta(): ?Venta {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): static {
        $this->venta = $venta;

        return $this;
    }
}
