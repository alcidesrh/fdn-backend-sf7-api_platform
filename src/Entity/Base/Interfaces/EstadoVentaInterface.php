<?php

namespace App\Entity\Base\Interfaces;

interface EstadoVentaInterface {
  public const ESTADO_EMITIDO = 1;
  public const ESTADO_CHEQUEADO = 2;
  public const ESTADO_TRANSITO = 3;
  public const ESTADO_ANULADO = 4;
  public const ESTADO_REASIGNADO = 5;
}
