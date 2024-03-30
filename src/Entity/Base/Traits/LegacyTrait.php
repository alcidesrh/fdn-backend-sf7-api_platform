<?php

namespace App\Entity\Base\Traits;

use Doctrine\ORM\Mapping as ORM;

trait LegacyTrait {
  #[ORM\Column(nullable: true)]
  protected ?int $legacyId = null;

  public function getLegacyId(): ?int {
    return $this->legacyId;
  }

  public function setLegacyId(int $legacyId): ?int {
    return $this->legacyId = $legacyId;
  }
}
