<?php

namespace App\Command;

use DateTime;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;

class RemoteDatabaseQueries {
  public function __construct(
    private EntityManagerInterface $systemfdn,
    private EntityManagerInterface $entityManagerInterface,
  ) {
  }

  public function getEstPaisLocAge() {
    $sql_pais = 'select * from pais p';
  }
  public function getEstaciones(): array {
    $sql = 'SELECT e.*,p.nombre as pais_nombre, d.nombre as dep_nombre from estacion e
            join pais p on p.id = e.pais_id
            join departamento d on d.id = e.departamento_id;';

    return $this->execute_query($sql);
  }

  public function getEmpresaBusPiloto(): array {
    $sql = 'SELECT * from empresa e where e.activo = 1';

    $sql2 = 'SELECT b.*, p.id as piloto_id, p.* from bus b
            join piloto p on p.id = b.piloto_id
            where b.estado_id = 1';

    return [$this->execute_query($sql), $this->execute_query($sql2)];
  }
  public function getUsuarioPorEstacion($id) {

    $sql = "SELECT * from custom_user u
            where u.estacion_id = $id and u.enabled = 1 and u.expired != 1 and u.locked != 1 and u.credentials_expired != 1";

    return $this->execute_query($sql);
  }
  public function test() {
    $sql = 'SELECT * from estacion e where e.activo = 1 and e.numEstablecimientoSatMayaDeOro  is not null and e.numEstablecimientoSat is null';

    $estaciones =  $this->execute_query($sql);

    $sql = 'SELECT * from empresa e where e.id in (2) and e.activo = 1';
    $empresas =  $this->execute_query($sql);

    return ['estaciones' => $estaciones, 'empresas' => $empresas];
  }

  public function updateDireccionEstacion($id, $direccion) {

    $sql = "UPDATE estacion SET direccion  = '$direccion' WHERE id = $id";

    return $this->execute_query_update($sql);
  }



  public function execute_query($sql, $params = [], $types = [ParameterType::STRING]) {

    try {
      return $this->systemfdn->getConnection()->executeQuery($sql, $params, $types)->fetchAllAssociative();
    } catch (\Throwable $e) {
      throw $e;
    }
  }

  public function execute_query_update($sql) {

    try {
      return $this->systemfdn->getConnection()->executeStatement($sql);
    } catch (\Throwable $e) {
      throw $e;
    }
  }
  public function request(string $endpoint, array $params, string $method = 'POST') {

    try {

      return json_decode(
        ($this->fdnClient->request(
          $method,
          $endpoint,
          [
            'body' => $params,
          ]
        )
        )->getContent(),
        true
      );
    } catch (\Throwable $e) {
      throw $e;

      // return ['error' => $e->getMessage(), 'code' => $e->getCode()];
    }

    return false;
  }
  public function ruta(): array {
    $sql = 'SELECT r.* from ruta r';
    $sql3 = 'SELECT * from ruta_estacion_item re';

    return [
      $this->execute_query($sql),
      $this->execute_query($sql3),
    ];
  }

  public function direcciones(): array {

    $num = [
      1,
      2,
      3,
      4,
      5,
      6,
      7,
      8,
      9,
      10,
      11,
      12,
      13,
      14,
      15,
      16,
      17,
      18,
      19,
      20,
      21,
      22,
      23,
      24,
      25,
      26
    ];

    $dir = [
      'CALZADA AGUILAR BATRES 7-55   , ZONA 12',
      '7  AVENIDA 11 CALLE    , ZONA 1 CANTON SAN NICOLAS',
      'ACCESO RURALES 2 SALIDA GUATEMALA 2122    , ZONA 3',
      '2 AVENIDA 8-03   , ZONA 3 BARRIO SAN FRANCISCO',
      '4 CALLE CARRETERA A TECUN HUMAN    , ZONA 1',
      '5 AVENIDA    , ZONA 1',
      'ALDEA EL CARMEN    , ZONA 0 SECTOR ADUANA',
      '2 CALLE 3-86   , ZONA 4',
      '7 CALLE 17-90   , ZONA 3',
      '2 ClALLE 1-090   , ZONA 1',
      'KILOMETRO 180 CARRETERA    , ZONA 0 CA-2 SUR',
      'COLONIA PINOS FINCA EL PORVENIR    , ZONA 0',
      '3 CALLE    , ZONA 1 BARRIO LA ESPERANZA',
      'ALDEA TOCACHE    , ZONA 0 CENTRO 8549',
      '4 CALLE 2-65    SAN JOSE-01 LOCAL 10',
      'AVENIDA INGRESO    , ZONA 0 ALDEA MONTE RICO',
      '1 CALLE 6-60   , ZONA 1 IZTAPA 01',
      'CARRETERA PACIFICO PETROVIC    , ZONA 0 RURALES',
      '2 AVENIDA SUR C 14    , ZONA 0 ANTIGUA-00,',
      '2 AVENIDA 8940    , ZONA 1',
      '3 AVENIDA    , ZONA 1',
      'AVENIDA VICENTE COZZA    , ZONA 0',
      'BARRIO CRUCE    , ZONA 0',
      'RUTA ATLANTICO    , ZONA 0 ALDEA MAYUELAS',
      'CALZADA AGUILAR BATRES APARTAMENTO A 16-36   , ZONA 11',
      'AVENIDA GAVILANES    , ZONA 0'
    ];

    $num2 = [
      27,
      28,
      29,
      30,
      31,
      32,
      33,
      34,
      35,
      36,
      37,
      38,
      39,
      40,
      41,
      42,
      43,
      44,
      45,
      46,
      47,
      48,
      49,
      50,
      51,
      52,
      53
    ];
    $dir2 = [
      'CALZ. AGUILAR BATRES 7-55   , ZONA 12',
      '2.0 AVENIDA    , ZONA 3 BARRIO SAN FRANCISCO',
      'ACCESO RURALES 2  SALIDA GUATEMALA 2122    , ZONA 3',
      '5 AVENIDA    , ZONA 1',
      '5A CALLE 2-22   , ZONA 1 CANTON SAN MIGUEL',
      '7A. AV. 11 CALLE    , ZONA 1 CANTON SAN NICOLAS',
      '17  CALLE 8-46   , ZONA 1',
      'BARRIO EL CENTRO     ',
      'CALLE PRINCIPAL     BARRIO  FALLABON',
      'MERCADO NUEVO SANTA ELENA    , ZONA 2',
      'BARRIO LA ESTACION     ',
      'CALLE PARQUE    , ZONA 1 BARRIO EL CENTRO',
      'RUTA AL ATLANTICO     ',
      'CARRETERA AL ATLANTICO 40-26   , ZONA 17 LOCAL E-97',
      'CALLE CENTRAL    , ZONA 1',
      'AVENIDA 15 DE SEPTIEMBRE    , ZONA 1',
      '1 CALLE    , ZONA 4 .',
      'BARRIO EL CENTRO    , ZONA 0',
      'MERCADO RIO DULCE    , ZONA 0',
      'BARRIO VISTA HERMOSA    , ZONA 0',
      'CALLE PRINCIPAL    , ZONA 0 ALDEA EL  NARANJO',
      'CALLE PRINCIPAL    , ZONA 0',
      'RUTA AL ATLANTICO    , ZONA 0',
      'CALLE EL MILAGRO    , ZONA 0 CASERIO EL CHAL',
      '11 CALLE 01-042   , ZONA 1',
      'COLONIA LAS ROSAS    , ZONA 5',
      '2 CALLE 3-86   , ZONA 4',
      '5 CALLE 12-81   , ZONA 3',
      '7 CALLE 17-90   , ZONA 3',
      '02 AVENIDA    , ZONA 1 OFICINA COMERCIAL SAN RAFAEL PIE DE LA CUESTA',
      'KILOMETRO 262.5 CARRETERA AL PACIFICO',
      'CASERIO LAS CHAMPAS ALDEA EL RANCHO',
      '3 AVENIDA    , ZONA 1',
      'SECTOR CRUCE MORALES    , ZONA 0',
      'CALLE 15DE SEPTIEMBRE    , ZONA 1',
      'KILOMETRO 180 CARRETERA    , ZONA 0 CA-2 SUR',
      'COLONIA PINOS FINCA EL PORVENIR    , ZONA 0',
      'ALDEA EL CARMEN SECTOR ADUANAL    , ZONA 0',
      '4 CALLE CARRETERA TECUN    , ZONA 1',
      '3 CALLE    , ZONA 1 COLONIA BARRIO ESPERANZA',
      'ALDEA TOCACHE    , ZONA 0 CENTRO',
      '4 CALLE 2-65    SAN JOSE -01 LOCAL 10',
      'AVENIDA INGRESO    , ZONA 0 ALDEA MONTERICO',
      '1 CALLE 6-60   , ZONA 1 IZTAPA-01',
      'CARRETERA PACIFICO RURALES    , ZONA 0',
      '2 AVENIDA    , ZONA 0 SUR C. 14, ANTIGUA -00',
      '2 AVENIDA 8940    , ZONA 1',
      '3 AVENIDA    , ZONA 1',
      'AVENIDA VICENTE COZZA    , ZONA 0',
      'BARRIO CRUCE    , ZONA 0',
      'RUTA ATLANTICO    , ZONA 0 ALDEA MAYUELAS',
      'CALZADA AGUILAR BATRES  APARTAMENTO A 16-36   , ZONA 11',
      'AVENIDA GAVILANES    , ZONA 0'
    ];
    for ($i = 0, $j = 1; $i < 54; $i++, $j++) {
      $sql = "update estacion set direccion = '{$dir2[$i]}' where numEstablecimientoSatMayaDeOro = $j";
      $estacion = $this->execute_query($sql);
    }
    return [];
  }
}
