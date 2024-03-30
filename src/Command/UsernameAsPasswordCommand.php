<?php

namespace App\Command;

use App\Entity\ApiToken;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'username_password_hasher',
    description: 'Establece com opassword los usernames.',
)]
class UsernameAsPasswordCommand extends Command {
    public function __construct(private EntityManagerInterface $entityManagerInterface, private UserPasswordHasherInterface $userPasswordHasherInterface, private UserRepository $userRepository) {
        parent::__construct();
    }

    protected function configure(): void {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {

        foreach ($this->userRepository->findAll() as $key => $value) {
            $value->setPassword($this->userPasswordHasherInterface->hashPassword($value, $value->getUsername()));
            $token = new ApiToken();
            $token->setUsuario($value);
            $this->entityManagerInterface->persist($token);
        }
        $this->entityManagerInterface->flush();
        return Command::SUCCESS;
    }
}
