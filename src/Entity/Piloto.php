<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\PersonaBase;
use App\Repository\PilotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PilotoRepository::class)]
#[ApiResource]
class Piloto extends PersonaBase {

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $licencia = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $licenciaVencimiento = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $dpi = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $sexo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $seguroSocial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nacionalidad = null;

    public function getlicencia(): ?string {
        return $this->licencia;
    }

    public function setlicencia(?string $licencia): static {
        $this->licencia = $licencia;

        return $this;
    }

    public function getlicenciaVencimiento(): ?\DateTimeInterface {
        return $this->licenciaVencimiento;
    }

    public function setlicenciaVencimiento(?\DateTimeInterface $licenciaVencimiento): static {
        $this->licenciaVencimiento = $licenciaVencimiento;

        return $this;
    }

    public function getDpi(): ?string {
        return $this->dpi;
    }

    public function setDpi(?string $dpi): static {
        $this->dpi = $dpi;

        return $this;
    }

    public function getSexo(): ?string {
        return $this->sexo;
    }

    public function setSexo(?string $sexo): static {
        $this->sexo = $sexo;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): static {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getSeguroSocial(): ?string {
        return $this->seguroSocial;
    }

    public function setSeguroSocial(?string $seguroSocial): static {
        $this->seguroSocial = $seguroSocial;

        return $this;
    }

    public function getNacionalidad(): ?string {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?string $nacionalidad): static {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }
}
