<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\InputStream;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'reset-db',
    description: 'Add a short description for your command',
)]
class ResetDatabaseCommand extends Command {
    public function __construct() {
        parent::__construct();
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

        try {
            $io = new SymfonyStyle($input, $output);
            $phpBinaryFinder = new PhpExecutableFinder();
            $phpBinaryPath = $phpBinaryFinder->find();

            $process = [
                [$phpBinaryPath, 'bin/console', 'doctrine:database:drop', '-nf', '--if-exists', '--quiet'],
                [$phpBinaryPath, 'bin/console', 'doctrine:database:create', '-n', '--quiet'],
                ['rm', '-r', 'migrations/*'],
                [$phpBinaryPath, 'bin/console', 'doctrine:migrations:diff', '-n', '--quiet'],
                [$phpBinaryPath, 'bin/console', 'doctrine:migrations:migrate', '-n', '--quiet']
            ];

            $io->progressStart(100);
            foreach ($process as $key => $value) {
                $io->progressAdvance(20);
                (new Process($value))->run();
            }
            $io->success('Base de datos generada!');
        } catch (\Throwable $th) {
            throw $th;
        }
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
