<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;


class PaisLocalidad {
    public function __construct(
        private EntityManagerInterface $entityManagerInterface,
        private EntityManagerInterface $systemfdn
    ) {
    }
    protected function configure(): void {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        // $this->entityManagerInterface->persist((new Asiento())->setNumero(10));
        // $this->entityManagerInterface->flush();
        $sql = 'SELECT TOP 10 s.id
                from salida s';
        $date = ((new \DateTime())->sub(new \DateInterval('P1D')))->format('Ymd H:i');

        try {

            $result = $this->systemfdn->getConnection()->executeQuery($sql)->fetchAllAssociative();
        } catch (\Throwable $e) {
            throw $e;
        }
        return Command::SUCCESS;
    }
}
