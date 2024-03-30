<?php

namespace App\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class Base {

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  protected ?int $id = null;

  public function getId(): ?int {
    return $this->id;
  }
}
