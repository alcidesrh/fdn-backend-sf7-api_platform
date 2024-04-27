<?php

declare(strict_types=1);

namespace App\ApiResource\Form;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Permiso;
use App\Services\FormKitGenerate;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;

class FormStateProvider implements ProviderInterface {

    public function __construct(private CreateForm $createForm) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null {


        // $return = new CreateForm($this->formKitGenerate);
        return $this->createForm->setClassName($uriVariables['className'])->getForm();
    }
}

//   {
//     $el: "div",
//     children: "Iniciar Sessión",
//     attrs: {
//       class: "u-text-l font-semibold text-zinc-600  mb-8 text-center",
//       style:
//         'font-variation-settings: "slnt" 0, "GRAD" -3, "XTRA" 400, "YOPQ" 106, "YTAS" 771, "YTDE" -268, "YTFI" 560, "YTLC" 514, "YTUC" 722; font-weight: 500; font-style: normal; font-stretch: 147.4 %;',
//     },
//   },
//   {
//     $formkit: "text",
//     name: "username",
//     label: "Usuario",
//     validation: "required",
//     labelClass: "u-text-m text-slate-700",
//   },
//   {
//     $formkit: "password",
//     name: "password",
//     label: "Contraseña",
//     validation: "required",
//     labelClass: "u-text-m text-slate-700",
//   },
//   {
//     $formkit: "submit",
//     name: "submit",
//     label: "Aceptar",
//     classes: {
//       wrapper: "flex justify-end mt-8",
//       input: "",
//     },
//   },
