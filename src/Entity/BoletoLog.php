<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\LogBase;
use App\Repository\BoletoLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoletoLogRepository::class)]
#[ApiResource]
class BoletoLog extends LogBase {

    #[ORM\ManyToOne(inversedBy: 'boletoLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Boleto $boleto = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $tipo = null;
    public function getBoleto(): ?Boleto {
        return $this->boleto;
    }

    public function setBoleto(?Boleto $boleto): static {
        $this->boleto = $boleto;

        return $this;
    }

    public function getTipo(): ?int {
        return $this->tipo;
    }

    public function setTipo(?int $tipo): static {
        $this->tipo = $tipo;

        return $this;
    }
}
