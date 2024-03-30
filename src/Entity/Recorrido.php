<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\NombreNotaStatusBase;
use App\Entity\Base\Traits\LegacyTrait;
use App\Repository\RecorridoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecorridoRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['recorrido' => Recorrido::class, 'ruta' => Ruta::class])]
#[ApiResource]
class Recorrido extends NombreNotaStatusBase {

    use LegacyTrait;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $tiempo = null;

    #[ORM\Column(nullable: true)]
    private ?float $distancia = null;

    #[ORM\ManyToOne]
    protected ?Parada $inicio = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn]
    protected ?Parada $final = null;

    #[ORM\OneToMany(mappedBy: 'recorrido', targetEntity: ParadaIntermedia::class, orphanRemoval: true)]
    private Collection $paradas;

    public function __construct() {
        $this->paradas = new ArrayCollection();
    }

    public function getTiempo(): ?\DateTimeInterface {
        return $this->tiempo;
    }
    public function setTiempo(?\DateTimeInterface $tiempo): static {
        $this->tiempo = $tiempo;

        return $this;
    }

    public function getDistancia(): ?float {
        return $this->distancia;
    }

    public function setDistancia(?float $distancia): static {
        $this->distancia = $distancia;

        return $this;
    }

    public function getInicio(): ?Parada {
        return $this->inicio;
    }

    public function setInicio(?Parada $inicio): static {
        $this->inicio = $inicio;

        return $this;
    }

    public function getFinal(): ?Parada {
        return $this->final;
    }

    public function setFinal(?Parada $final): static {
        $this->final = $final;

        return $this;
    }

    /**
     * @return Collection<int, ParadaIntermedia>
     */
    public function getParadas(): Collection {
        return $this->paradas;
    }

    public function addParada(ParadaIntermedia $parada): static {
        if (!$this->paradas->contains($parada)) {
            $this->paradas->add($parada);
            $parada->setRecorrido($this);
        }

        return $this;
    }

    public function removeParada(ParadaIntermedia $parada): static {
        if ($this->paradas->removeElement($parada)) {
            // set the owning side to null (unless already changed)
            if ($parada->getRecorrido() === $this) {
                $parada->setRecorrido(null);
            }
        }

        return $this;
    }
}
