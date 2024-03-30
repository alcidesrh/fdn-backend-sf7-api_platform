<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Base\Base;
use App\Repository\FDNRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FDNRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['fdn' => FDN::class, 'enclave' => Enclave::class, 'parada' => Parada::class])]
#[ApiResource]
class FDN extends Base {
}
