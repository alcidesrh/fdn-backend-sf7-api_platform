<?php

namespace App\ApiResource\Form;

use function Symfony\Component\String\u;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Entity\Permiso;
use App\Services\FormKitGenerate;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;

#[ApiResource(
  shortName: 'create_form',
  provider: FormStateProvider::class,
  operations: [
    new Get()
  ]

)]
class CreateForm {


  #[Ignore]
  private string $form;

  // #[Ignore]
  // private FormKitGenerate $formKitGenerate;

  private string $className;

  public function __construct(private FormKitGenerate $formKitGenerate) {
    // $this->className = $className;
    // $formKitGenerate = $formKitGenerate;
    // $this->form = $formKitGenerate->form($className);
  }


  public function getForm() {
    return $this->formKitGenerate->create($this->className);
  }
  #[ApiProperty(identifier: true, readable: false)]
  public function getClassName(): string {
    return $this->className;
  }

  public function setClassName(string $className): self {
    $this->className = $className;
    return $this;
  }
}
