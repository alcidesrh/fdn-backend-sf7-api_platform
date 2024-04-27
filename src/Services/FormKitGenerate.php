<?php

namespace App\Services;

use function Symfony\Component\String\u;

use App\Attribute\FormCreateExclude;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Finder\Finder;

#[Attribute]
class FormKitGenerate {

  private ArrayCollection $form;

  public function __construct(private EntityManagerInterface $entityManager, #[Autowire('%kernel.project_dir%/src/Entity')]
  private $entityDir,) {
    $this->form = new ArrayCollection();
  }

  public function create($className) {

    if ($className == 'entity') {
      return [[
        '$formkit' => 'select',
        'label' => 'Entidades',
        'name' => 'entity',
        'options' => $this->entityList()
      ]];
    }
    try {


      $className = u($className)->camel()->title();
      $className = "App\Entity\\$className";

      $reflectionClass = new ReflectionClass($className);
      $info = self::getExtractor();
      $properties = $info->getProperties($className);
      // $metadata = $this->getClassMetadata($className);
      // $properties = \array_merge($metadata->getFieldNames(), $metadata->getAssociationNames());
      foreach ($properties as $value) {

        try {
          $attrs = $reflectionClass->getProperty($value)->getAttributes();

          if (\in_array(FormCreateExclude::class, \array_map(fn ($i) => $i->getName(), $attrs))) {
            continue;
          }
        } catch (\ReflectionException $th) {
          continue;
        }

        $typeInfo = $info->getTypes($className, $value)[0];
        $type = $typeInfo->getBuiltinType();
        $collectionValueTypes = $typeInfo->getCollectionValueTypes();

        if (!empty($collectionValueTypes)) {
          $class =  $collectionValueTypes[0]->getClassName();
        } else {
          $class = $typeInfo?->getClassName();
        }
        $data[] = [
          'name' => $value,
          'type' => $type,
          'class' => $class

        ];
      }

      return $this->getForm($data);
    } catch (\Throwable $th) {
      // throw $th;
    }
  }


  public function getForm(array $data) {

    $form = [];


    foreach ($data as $key => $value) {

      list($name, $type, $class) = \array_values($value);

      $input = self::getInputType($type, $class);

      $form[] = [
        '$formkit' => $input,
        'label' => \ucwords($name),
        'name' => \strtolower($name),
        'labelClass' => 'text',
        'validation' => 'required'
      ];

      $aux = function ($el) {
        return ['label' => (string)$el, 'value' => $el->getId()];
      };

      if ($input == 'select' && $class && $class != DateTimeInterface::class) {
        $form[$key]['options']  = (new ArrayCollection($this->entityManager->getRepository($class)->findAll()))->map($aux)->toArray();
      }
      if ($type == 'array') {
        $form[$key]['multiple'] = true;
      }
    }

    // return [$form[0], $form[2], $form[3], $form[1], $form[4]];

    return $form;
  }

  static function getExtractor() {
    // $phpDocExtractor = new PhpDocExtractor();
    $reflectionExtractor = new ReflectionExtractor();
    // // list of PropertyListExtractorInterface (any iterable)
    $listExtractors = [$reflectionExtractor];
    // // list of PropertyTypeExtractorInterface (any iterable)
    $typeExtractors = [$reflectionExtractor];
    // // list of PropertyAccessExtractorInterface (any iterable)
    $accessExtractors = [$reflectionExtractor];
    // // list of PropertyInitializableExtractorInterface (any iterable)
    $propertyInitializableExtractors = [$reflectionExtractor];

    return new PropertyInfoExtractor(
      $listExtractors,
      $typeExtractors,
      [],
      $accessExtractors,
      $propertyInitializableExtractors
    );
  }

  static function getInputType($type, $class) {

    if ($type == 'object' || $type == 'array') {
      if ($class == DateTimeInterface::class) {
        return 'date';
      }
      return 'select';
    }
    return 'text';
  }

  public function entityList() {
    $finder = new Finder();
    // find all files in the current directory
    $finder->files()->in($this->entityDir)->depth(0);
    $options = [['label' => 'Entidades', 'value' => 0]];
    foreach ($finder as $file) {
      // }
      $options[] = ['label' => $file->getFilenameWithoutExtension(), 'value' => $file->getFilenameWithoutExtension()];
    }

    return $options;
  }
}
