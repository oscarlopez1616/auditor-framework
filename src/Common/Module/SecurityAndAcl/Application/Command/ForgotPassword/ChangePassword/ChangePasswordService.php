<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ForgotPassword\ChangePassword;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\Exception\TransactionalApplicationException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\TransactionAwareApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception\InvalidPasswordRecoveryException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryReadModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
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
     * @param UserId $id
     * @param PasswordRecoveryId $passwordRecoveryId
     * @param string $newPassword
     * @throws ConnectionException
     * @throws Throwable
     */
    public function execute(
        UserId $id,
        PasswordRecoveryId $passwordRecoveryId,
        string $newPassword
    ): void
    {
        $this->beginTransaction();
        try {
            $user = $this->userReadModelRepository->findOrFailByUserId($id);
            $passwordRecovery = $this->passwordRecoveryReadModelRepository->findOrFailLastCreatedByUserId($id);
            if (!$passwordRecovery->isValid($passwordRecoveryId)) {
                throw new InvalidPasswordRecoveryException($passwordRecoveryId->value());
            }
            $passwordRecovery->use();
            $user->changePassword(password_hash($newPassword, PASSWORD_ARGON2I));
            $this->passwordRecoveryReadModelRepository->save($passwordRecovery);
            $this->userReadModelRepository->save($user);
            $this->saveInWriteModel([$passwordRecovery, $user]);
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
