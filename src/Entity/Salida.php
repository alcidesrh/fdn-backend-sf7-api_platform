<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\TimeStatusBase;
use App\Repository\SalidaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalidaRepository::class)]
#[ApiResource]
class Salida extends TimeStatusBase {

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne]
    private ?Bus $bus = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recorrido $recorrido = null;

    #[ORM\ManyToOne]
    private ?Empresa $empresa = null;

    #[ORM\OneToMany(mappedBy: 'salida', targetEntity: SalidaLog::class)]
    private Collection $salidaLogs;

    #[ORM\OneToMany(mappedBy: 'salida', targetEntity: Boleto::class)]
    private Collection $boletos;

    public function __construct() {
        $this->salidaLogs = new ArrayCollection();
        $this->boletos = new ArrayCollection();
    }

    public function getFecha(): ?\DateTimeInterface {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): static {
        $this->fecha = $fecha;

        return $this;
    }

    public function getBus(): ?Bus {
        return $this->bus;
    }

    public function setBus(?Bus $bus): static {
        $this->bus = $bus;

        return $this;
    }

    public function getRecorrido(): ?Recorrido {
        return $this->recorrido;
    }

    public function setRecorrido(?Recorrido $recorrido): static {
        $this->recorrido = $recorrido;

        return $this;
    }



    public function getEmpresa(): ?Empresa {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): static {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * @return Collection<int, SalidaLog>
     */
    public function getSalidaLogs(): Collection {
        return $this->salidaLogs;
    }

    public function addSalidaLog(SalidaLog $salidaLog): static {
        if (!$this->salidaLogs->contains($salidaLog)) {
            $this->salidaLogs->add($salidaLog);
            $salidaLog->setSalida($this);
        }

        return $this;
    }

    public function removeSalidaLog(SalidaLog $salidaLog): static {
        if ($this->salidaLogs->removeElement($salidaLog)) {
            // set the owning side to null (unless already changed)
            if ($salidaLog->getSalida() === $this) {
                $salidaLog->setSalida(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Boleto>
     */
    public function getBoletos(): Collection {
        return $this->boletos;
    }

    public function addBoleto(Boleto $boleto): static {
        if (!$this->boletos->contains($boleto)) {
            $this->boletos->add($boleto);
            $boleto->setSalida($this);
        }

        return $this;
    }

    public function removeBoleto(Boleto $boleto): static {
        if ($this->boletos->removeElement($boleto)) {
            // set the owning side to null (unless already changed)
            if ($boleto->getSalida() === $this) {
                $boleto->setSalida(null);
            }
        }

        return $this;
    }
}
