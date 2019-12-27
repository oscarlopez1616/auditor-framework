<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Ui\Cli;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\CreateUser\CreateUserCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\UserAlreadyExistException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class CreateInitialUsersIfNotExistsController extends Command
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var array
     */
    private $userPasswordsByUserName;

    /**
     * @var string
     */
    private $initialSecurityAndAclUsersDataPath;

    public function __construct(
        CommandBus $commandBus,
        array $userPasswordsByUserName,
        string $initialSecurityAndAclUsersDataPath
    ) {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->userPasswordsByUserName = $userPasswordsByUserName;
        $this->initialSecurityAndAclUsersDataPath = $initialSecurityAndAclUsersDataPath;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $usersData = $this->readUsersData();

        foreach ($usersData as $userData) {
            try {
                $command = new CreateUserCommand(
                    $userData['id'],
                    $userData['userName'],
                    $userData['roles'],
                    $this->userPasswordsByUserName[$userData['userName']],
                    $userData['active'],
                    $userData['userType']
                );

                $this->commandBus->dispatch($command);
                $output->writeln("User {$userData['userName']} created");
            } catch (UserAlreadyExistException $e) {
                $output->writeln("User {$userData['userName']} already exists, skipping...");
            }
        }
    }

    private function readUsersData(): array
    {
        return Yaml::parseFile($this->initialSecurityAndAclUsersDataPath);
    }

    protected function configure()
    {
        $this
            ->setName('auditor_framework:security-and-acl:create-initial-users')
            ->setDescription('Create initial users in the SecurityAndAcl Module');
    }
}
