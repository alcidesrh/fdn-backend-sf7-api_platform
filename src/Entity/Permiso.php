<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Attribute\FormCreateExclude;
use App\Entity\Base\Base;
use App\Entity\Base\NombreNotaStatusBase;
use App\Repository\PermisoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermisoRepository::class)]
#[ApiResource]
class Permiso extends NombreNotaStatusBase {

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'hijos')]
    private ?self $padre = null;

    #[ORM\OneToMany(mappedBy: 'padre', targetEntity: self::class)]
    private Collection $hijos;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $nivel = null;

    #[FormCreateExclude]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'permisos')]
    private Collection $usuarios;

    public function __construct() {
        $this->hijos = new ArrayCollection();
        $this->usuarios = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPadre(): ?self {
        return $this->padre;
    }

    public function setPadre(?self $padre): static {
        $this->padre = $padre;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getHijos(): Collection {
        return $this->hijos;
    }

    public function addHijo(self $hijo): static {
        if (!$this->hijos->contains($hijo)) {
            $this->hijos->add($hijo);
            $hijo->setPadre($this);
        }

        return $this;
    }

    public function removeHijo(self $hijo): static {
        if ($this->hijos->removeElement($hijo)) {
            // set the owning side to null (unless already changed)
            if ($hijo->getPadre() === $this) {
                $hijo->setPadre(null);
            }
        }

        return $this;
    }

    public function getNivel(): ?int {
        return $this->nivel;
    }

    public function setNivel(?int $nivel): static {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsuarios(): Collection {
        return $this->usuarios;
    }

    public function addUsuario(User $usuario): static {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
        }

        return $this;
    }

    public function removeUsuario(User $usuario): static {
        $this->usuarios->removeElement($usuario);

        return $this;
    }
    static function createForm() {
        return '
    $el: "div",
    children: "Iniciar Sessión",
    attrs: {
      class: "u-text-l font-semibold text-zinc-600  mb-8 text-center",
      style:
        \'font-variation-settings: "slnt" 0, "GRAD" -3, "XTRA" 400, "YOPQ" 106, "YTAS" 771, "YTDE" -268, "YTFI" 560, "YTLC" 514, "YTUC" 722; font-weight: 500; font-style: normal; font-stretch: 147.4 %;\',
    },
  },
  {
    $formkit: "text",
    name: "username",
    label: "Usuario",
    validation: "required",
    labelClass: "u-text-m text-slate-700",
  },
  {
    $formkit: "password",
    name: "password",
    label: "Contraseña",
    validation: "required",
    labelClass: "u-text-m text-slate-700",
  },
  {
    $formkit: "submit",
    name: "submit",
    label: "Aceptar",
    classes: {
      wrapper: "flex justify-end mt-8",
      input: "",
    },
  },';
    }
}
