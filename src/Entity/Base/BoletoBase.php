<?php

namespace App\Entity\Base;

use App\Entity\Base\Interfaces\EstadoVentaInterface;
use App\Entity\Base\Interfaces\StatusInterface;
use App\Entity\Base\Traits\StatusTrait;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\DBAL\Types\Types;

#[ORM\MappedSuperclass]
class BoletoBase extends Base implements EstadoVentaInterface, StatusInterface {

  use StatusTrait, TimestampableEntity;

  public const ASIENTO_CLASE_A = 'A';
  public const ASIENTO_CLASE_B = 'B';

  #[ORM\Column(type: Types::SMALLINT)]
  protected ?int $estado = null;

  public function getEstado(): ?int {
    return $this->estado;
  }

  public function setEstado(?int $estado): static {
    $this->estado = $estado;

    return $this;
  }
}
