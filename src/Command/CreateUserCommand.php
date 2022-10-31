<?php

namespace App\Command;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Uid\Uuid;

#[AsCommand(name: 'user:create')]
class CreateUserCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->addArgument('userName', InputArgument::REQUIRED, 'Username of the account.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $userName = $input->getArgument('userName');
        if (!$userName) {
            $io->error('Please enter a username.');

            return Command::FAILURE;
        }

        $helper = $this->getHelper('question');
        $question = new Question('What should the password of ' . $userName . ' be?');
        $plainPassword = $helper->ask($input, $output, $question);
        if (!$plainPassword) {
            $io->error('Please enter a password.');

            return Command::FAILURE;
        }

        $user = (new User())
            ->setId(Uuid::v1())
            ->setPassword(password_hash($plainPassword, PASSWORD_ARGON2ID))
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername($userName)
            ->setCreated(new DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('The user ' . $user->getUsername() . ' has successfully been created.');

        return Command::SUCCESS;
    }
}
