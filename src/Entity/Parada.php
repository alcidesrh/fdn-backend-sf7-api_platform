<?php

namespace App\Entity;

use App\Entity\Base\NombreNotaStatusBase;
use App\Repository\ParadaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParadaRepository::class)]
class Parada extends NombreNotaStatusBase {
    #[ORM\ManyToOne]
    private ?Enclave $enclave = null;

    #[ORM\ManyToMany(targetEntity: Recorrido::class, inversedBy: 'paradas')]
    private Collection $recorridos;

    public function __construct() {
        $this->recorridos = new ArrayCollection();
    }


    public function getEnclave(): ?Enclave {
        return $this->enclave;
    }

    public function setEnclave(?Enclave $enclave): static {
        $this->enclave = $enclave;

        return $this;
    }

    /**
     * @return Collection<int, Recorrido>
     */
    public function getRecorridos(): Collection {
        return $this->recorridos;
    }

    public function addRecorrido(Recorrido $recorrido): static {
        if (!$this->recorridos->contains($recorrido)) {
            $this->recorridos->add($recorrido);
        }

        return $this;
    }

    public function removeRecorrido(Recorrido $recorrido): static {
        $this->recorridos->removeElement($recorrido);

        return $this;
    }
}
