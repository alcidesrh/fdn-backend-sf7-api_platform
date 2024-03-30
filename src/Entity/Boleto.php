<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\BoletoBase;
use App\Repository\BoletoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoletoRepository::class)]
#[ApiResource]
class Boleto extends BoletoBase {

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cliente $cliente = null;

    #[ORM\Column(nullable: true)]
    private ?float $precio = null;

    #[ORM\OneToMany(mappedBy: 'boleto', targetEntity: BoletoLog::class)]
    private Collection $boletoLogs;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Asiento $asiento = null;

    #[ORM\ManyToOne(inversedBy: 'boletos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salida $salida = null;

    public function getCliente(): ?Cliente {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static {
        $this->cliente = $cliente;

        return $this;
    }

    public function getPrecio(): ?float {
        return $this->precio;
    }

    public function setPrecio(?float $precio): static {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @return Collection<int, BoletoLog>
     */
    public function getBoletoLogs(): Collection {
        return $this->boletoLogs;
    }

    public function addBoletoLog(BoletoLog $boletoLog): static {
        if (!$this->boletoLogs->contains($boletoLog)) {
            $this->boletoLogs->add($boletoLog);
            $boletoLog->setBoleto($this);
        }

        return $this;
    }

    public function removeBoletoLog(BoletoLog $boletoLog): static {
        if ($this->boletoLogs->removeElement($boletoLog)) {
            // set the owning side to null (unless already changed)
            if ($boletoLog->getBoleto() === $this) {
                $boletoLog->setBoleto(null);
            }
        }

        return $this;
    }

    public function getAsiento(): ?Asiento {
        return $this->asiento;
    }

    public function setAsiento(?Asiento $asiento): static {
        $this->asiento = $asiento;

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
