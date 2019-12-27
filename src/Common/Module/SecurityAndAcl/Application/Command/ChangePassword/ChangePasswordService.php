<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ChangePassword;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\Exception\TransactionalApplicationException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\TransactionAwareApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryReadModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\InvalidOldPasswordException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;
use Throwable;

class ChangePasswordService extends TransactionAwareApplicationService
{
    /**
     * @var UserReadModelRepository
     */
    private $userReadModelRepository;

    /**
     * @var PasswordRecoveryReadModelRepository
     */
    private $passwordRecoveryReadModelRepository;

    public function __construct(
        UserReadModelRepository $userReadModelRepository,
        PasswordRecoveryReadModelRepository $passwordRecoveryReadModelRepository,
        EntityManager $entityManager,
        WriteModelRepository $writeModelRepository
    ) {
        parent::__construct($entityManager, $writeModelRepository);
        $this->userReadModelRepository = $userReadModelRepository;
        $this->passwordRecoveryReadModelRepository = $passwordRecoveryReadModelRepository;
    }

    /**
     * @param UniqueEmail $userName
     * @param string $oldPassword
     * @param string $newPassword
     * @throws ConnectionException
     * @throws Throwable
     */
    public function execute(UniqueEmail $userName, string $oldPassword, string $newPassword): void
    {
        $this->beginTransaction();
        try {
            $user = $this->userReadModelRepository->findOrFailByUserName($userName);
            if (!$user->isValidPassword($oldPassword)) {
                throw new InvalidOldPasswordException($oldPassword);
            }
            $user->changePassword(password_hash($newPassword, PASSWORD_ARGON2I));
            $this->userReadModelRepository->save($user);
            $this->saveInWriteModel([$user]);
            $this->commit();
        } catch (Throwable $e) {
            $this->rollBack();
            if ($e instanceof DomainException) {
                throw $e;
            }
            throw new TransactionalApplicationException($e->getMessage());
        }
    }
}
