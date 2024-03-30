<?php

namespace App\Entity\Base\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

trait StatusTrait {

  #[ORM\Column(type: Types::SMALLINT)]
  protected ?int $status = 1;

  public function getStatus(): ?int {
    return $this->status;
  }

  public function setStatus(?int $status): static {
    $this->status = $status;

    return $this;
  }
}
