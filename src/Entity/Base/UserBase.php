<?php

namespace App\Entity\Base;

use App\Entity\Base\Interfaces\StatusInterface;
use App\Entity\Base\Traits\PersonaTrait;
use App\Entity\Base\Traits\StatusTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class UserBase extends TimeLegacyStatusBase implements StatusInterface {
  use PersonaTrait, StatusTrait;
}
