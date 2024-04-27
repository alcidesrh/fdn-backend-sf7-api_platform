<?php

namespace App\Entity;

use App\Entity\Base\NombreNotaStatusBaseSuperClass;
use App\Repository\EnclaveRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: EnclaveRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['enclave' => Enclave::class, 'estacion' => Estacion::class, 'agencia' => Agencia::class])]
#[ApiResource]
class Enclave extends NombreNotaStatusBaseSuperClass {

  #[ORM\Column(length: 50, nullable: true)]
  protected ?string $email = null;

  #[ORM\Column(length: 15, nullable: true)]
  protected ?string $telefono = null;

  #[ORM\Column(length: 255, nullable: true)]
  protected ?string $direccion = null;

  #[ORM\ManyToOne]
  protected ?Localidad $localidad = null;

  public function getEmail(): ?string {
    return $this->email;
  }

  public function setEmail(?string $email): static {
    $this->email = $email;

    return $this;
  }
  public function getTelefono(): ?string {
    return $this->telefono;
  }

  public function setTelefono(?string $telefono): static {
    $this->telefono = $telefono;

    return $this;
  }

  public function getDireccion(): ?string {
    return $this->direccion;
  }

  public function setDireccion(?string $direccion): static {
    $this->direccion = $direccion;

    return $this;
  }
  public function getLocalidad(): ?Localidad {
    return $this->localidad;
  }

  public function setLocalidad(?Localidad $localidad): static {
    $this->localidad = $localidad;

    return $this;
  }
}
