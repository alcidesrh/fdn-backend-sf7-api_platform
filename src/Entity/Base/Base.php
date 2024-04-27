<?php

namespace App\Entity\Base;

use App\Attribute\FormCreateExclude;
use Doctrine\ORM\Mapping as ORM;
use ReflectionClass;

#[ORM\MappedSuperclass]
class Base {

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[FormCreateExclude]
  protected ?int $id = null;

  public function getId(): ?int {
    return $this->id;
  }

  public function __toString() {

    $class = get_class($this);
    $reflectionClass = new ReflectionClass($class);

    if (!empty($nombre = \array_filter($reflectionClass->getProperties(), fn ($i) => \in_array($i->getName(), ['nombre', 'name'])))) {
      return $this->getNombre() ?? $class;
    }
    return '';
  }
}
