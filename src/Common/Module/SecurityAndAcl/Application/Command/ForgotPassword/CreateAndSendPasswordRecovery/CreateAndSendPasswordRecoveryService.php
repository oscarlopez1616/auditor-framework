<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ForgotPassword\CreateAndSendPasswordRecovery;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use AuditorFramework\Common\Types\Application\Exception\TransactionalApplicationException;
use AuditorFramework\Common\Types\Application\TransactionAwareApplicationService;
use AuditorFramework\Common\Types\Domain\AmqpCommandPublisherService;
use AuditorFramework\Common\Types\Domain\Exception\DomainException;
use AuditorFramework\Common\Types\Domain\WriteModelRepository;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Event\PasswordRecoveryWasCreatedEvent;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecovery;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryReadModelRepository;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;
use Throwable;

class CreateAndSendPasswordRecoveryService extends TransactionAwareApplicationService
{
    /**
     * @var UserReadModelRepository
     */
    private $userReadModelRepository;

    /**
     * @var PasswordRecoveryReadModelRepository
     */
    private $passwordRecoveryReadModelRepository;

    /**
     * @var AmqpCommandPublisherService
     */
    private $amqpCommandPublisherService;

    public function __construct(
        UserReadModelRepository $userReadModelRepository,
        PasswordRecoveryReadModelRepository $passwordRecoveryReadModelRepository,
        AmqpCommandPublisherService $amqpCommandPublisherService,
        EntityManager $entityManager,
        WriteModelRepository $writeModelRepository
    ) {
        parent::__construct($entityManager, $writeModelRepository);
        $this->userReadModelRepository = $userReadModelRepository;
        $this->passwordRecoveryReadModelRepository = $passwordRecoveryReadModelRepository;
        $this->amqpCommandPublisherService = $amqpCommandPublisherService;
    }

    /**
     * @param PasswordRecoveryId $passwordRecoveryId
     * @param UniqueEmail $userName
     * @throws ConnectionException
     * @throws Throwable
     */
    public function execute(PasswordRecoveryId $passwordRecoveryId, UniqueEmail $userName): void
    {
        $this->beginTransaction();
        try {
            $user = $this->userReadModelRepository->findOrFailByUserName($userName);
            $passwordRecovery = PasswordRecovery::create(
                $passwordRecoveryId,
                $user->id()
            );
            $this->passwordRecoveryReadModelRepository->save($passwordRecovery);

            $passwordRecoveryWasCreatedEvent = $passwordRecovery->unPersistedRecordedEventByEventClassNamespace(
                PasswordRecoveryWasCreatedEvent::class
            );

            $this->saveInWriteModel([$passwordRecovery]);

            $this->amqpCommandPublisherService->publish($passwordRecoveryWasCreatedEvent);

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
