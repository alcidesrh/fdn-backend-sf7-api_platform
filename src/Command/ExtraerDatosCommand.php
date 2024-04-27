<?php

namespace App\Command;

use App\Entity\Agencia;
use App\Entity\Estacion;
use App\Entity\Parada;
use App\Entity\Ruta;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'migrar',
    description: 'Add a short description for your command',
)]
class ExtraerDatosCommand extends Command {
    public function __construct(
        private EntityManagerInterface $entityManagerInterface,
        private EntityManagerInterface $systemfdn,
        private RemoteDatabaseQueries $remoteDatabaseQueries,
    ) {
        parent::__construct();
    }
    protected function configure(): void {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        try {

            $this->estacionLocalidadPaisUsuarios();
            $this->empresaBusPiloto();
            $this->ruta();
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            throw $e;
        }
        return Command::SUCCESS;
    }


    public function estacionLocalidadPaisUsuarios() {
        if ($estaciones = $this->remoteDatabaseQueries->getEstaciones()) {
            $pais_nombre = [];
            $dep_nombre = [];
            foreach ($estaciones as $key => $value) {
                if (!\array_key_exists($value['pais_nombre'], $pais_nombre)) {
                    $item2 = Factory::create(class_name: 'pais', data: $value, include: ['pais_nombre' => 'nombre'], exclude: ['nombre']); //(new Pais)->setNombre(\ucwords($value['nombre']));
                    $pais_nombre[$value['pais_nombre']] = $item2;
                    $this->entityManagerInterface->persist($item2);
                    $value['pais'] = $item2;
                }
                if (!\array_key_exists($value['dep_nombre'], $dep_nombre)) {
                    $item3 = Factory::create(class_name: 'localidad', data: $value, include: ['dep_nombre' => 'nombre'], exclude: ['nombre']);
                    $dep_nombre[$value['dep_nombre']] = $item3;
                    $this->entityManagerInterface->persist($item3);
                    $value['localidad'] = $item3;
                }
                $tipo = $value["tipoEstacion_id"] == 4 ? 'Agencia' : 'Estacion';
                $item = Factory::create(class_name: $tipo, data: $value, include: ['id' => 'legacy_id']);

                $this->entityManagerInterface->persist($item);

                if ($usuarios = $this->remoteDatabaseQueries->getUsuarioPorEstacion($value['id'])) {
                    foreach ($usuarios as $value) {
                        $exclude = ['roles'];
                        if ($tipo == 'Agencia') {
                            $exclude[] = 'estacion';
                            $value['agencia'] = $item;
                        } else {
                            $value['estacion'] = $item;
                        }
                        $user = Factory::create(class_name: 'user', data: $value, include: ['names' => 'nombre', 'surnames' => 'apellido', 'phone' => 'telefono', 'id' => 'legacy_id'], exclude: $exclude);
                        $this->entityManagerInterface->persist($user);
                    }
                }
            }

            $this->entityManagerInterface->flush();
        }
    }

    public function empresaBusPiloto() {
        if ($items = $this->remoteDatabaseQueries->getEmpresaBusPiloto()) {
            foreach ($items[0] as $key => $value) {
                $item = Factory::create(class_name: 'empresa', data: $value, include: ['id' => 'legacy_id']);
                $this->entityManagerInterface->persist($item);
                $empresas[$value['id']] = $item;
            }

            $marcas = [
                '',
                'CETRA',
                'Challenger',
                'DINA',
                'HINO',
                'MARCOPOLO',
                'MCI',
                'Mercedes',
                'MITSUBISHI',
                'Nissan',
                'Scania',
                'SPRINTER',
                'Volswagen',
                'VOLVO',
                'Zetra'
            ];
            foreach ($items[1] as $key => $value) {
                $value['fechaNacimiento'] = $value['fechaNacimiento'] ? new DateTime($value['fechaNacimiento']) : null;
                $value['fechaVencimientoLicencia'] = $value['fechaVencimientoLicencia'] ? new DateTime($value['fechaVencimientoLicencia']) : null;
                $piloto = Factory::create(class_name: 'piloto', data: $value, include: ['id' => 'legacy_id', 'numeroLicencia' => 'licencia', 'fechaVencimientoLicencia' => 'licenciaVencimiento', 'apellidos' => 'apellido']);


                $value['marca'] = $marcas[$value['marca_id']];
                $item = Factory::create(class_name: 'bus', data: [...$value, ...['piloto' => $piloto, 'empresa' => $empresas[$value['empresa_id']]]], include: ['id' => 'legacy_id']);
                $this->entityManagerInterface->persist($item);
            }

            $this->entityManagerInterface->flush();
        }
    }

    public function ruta() {
        list($rutas, $intermedias) = $this->remoteDatabaseQueries->ruta();

        $agenciaRepository = $this->entityManagerInterface->getRepository(Agencia::class);
        $estacionRepository = $this->entityManagerInterface->getRepository(Estacion::class);
        $rutaRepository = $this->entityManagerInterface->getRepository(
            Ruta::class
        );
        $paradaRepository = $this->entityManagerInterface->getRepository(Parada::class);

        foreach ($rutas as $value) {
            if (!$e = $estacionRepository->findOneBy(['legacyId' => $value['estacion_origen_id']])) {
                if (!$e = $agenciaRepository->findOneBy(['legacyId' => $value['estacion_origen_id']])) {
                    continue;
                }
            }
            if (!$e2 = $estacionRepository->findOneBy(['legacyId' => $value['estacion_destino_id']])) {
                if (!$e2 = $agenciaRepository->findOneBy(['legacyId' => $value['estacion_destino_id']])) {
                    continue;
                }
            }

            if (!$inicio = $paradaRepository->findOneBy(['enclave' => $e])) {
                $inicio = Factory::create('parada', ['enclave' => $e]);
            }
            if (!$final = $paradaRepository->findOneBy(['enclave' => $e2])) {
                $final = Factory::create('parada', ['enclave' => $e2]);
            }
            $this->entityManagerInterface->persist($inicio);
            $this->entityManagerInterface->persist($final);

            $recorrido = Factory::create('ruta', [...$value, 'inicio' => $inicio, 'final' => $final], ['kilometros' => 'distancia', 'id' => 'legacyId']);
            $this->entityManagerInterface->persist($recorrido);
        }
        $this->entityManagerInterface->flush();

        foreach ($intermedias as $key => $value) {

            if ($ruta = $rutaRepository->findOneBy(['codigo' => $value['ruta_codigo']])) {
                if (!$enclave = $estacionRepository->findOneBy(['legacyId' => $value['estacion_id']])) {
                    if (!$enclave = $agenciaRepository->findOneBy(['legacyId' => $value['estacion_id']])) {
                        continue;
                    }
                }
                if (!$parada = $paradaRepository->findOneBy(['enclave' => $enclave])) {
                    $parada = Factory::create('parada', ['enclave' => $enclave]);
                    $this->entityManagerInterface->persist($parada);
                }
                $intermedia = Factory::create('ParadaIntermedia', ['parada' => $parada, 'recorrido' => $ruta, 'posicion' => $value['posicion']]);
                $this->entityManagerInterface->persist($intermedia);
            }
        }
        $this->entityManagerInterface->flush();
        return $rutas;
    }
}
