<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\TimeStatusBase;
use App\Repository\VentaRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
#[ApiResource]
class Venta extends TimeStatusBase {


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salida $ida = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salida $regreso = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?float $precio = null;

    #[ORM\OneToOne(inversedBy: 'venta', cascade: ['persist', 'remove'])]
    private ?Factura $factura = null;


    public function getIda(): ?Salida {
        return $this->ida;
    }

    public function setIda(?Salida $ida): static {
        $this->ida = $ida;

        return $this;
    }

    public function getRegreso(): ?Salida {
        return $this->regreso;
    }

    public function setRegreso(?Salida $regreso): static {
        $this->regreso = $regreso;

        return $this;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): static {
        $this->user = $user;

        return $this;
    }

    public function getPrecio(): ?float {
        return $this->precio;
    }

    public function setPrecio(?float $precio): static {
        $this->precio = $precio;

        return $this;
    }

    public function getFactura(): ?Factura {
        return $this->factura;
    }

    public function setFactura(?Factura $factura): static {
        // unset the owning side of the relation if necessary
        if ($factura === null && $this->factura !== null) {
            $this->factura->setVenta(null);
        }

        // set the owning side of the relation if necessary
        if ($factura !== null && $factura->getVenta() !== $this) {
            $factura->setVenta($this);
        }

        $this->factura = $factura;

        return $this;
    }
}
