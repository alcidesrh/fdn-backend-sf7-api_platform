<?php

namespace App\Factory;

use App\Services\FormKitGenerate;
use Doctrine\ORM\EntityManager;

class FormKitFactory {

  public static function create(EntityManager $entityManager) {
    return new FormKitGenerate($entityManager);
  }
}
