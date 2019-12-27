<?php


namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\UnblockUser;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\Exception\TransactionalApplicationException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\TransactionAwareApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;
use Throwable;

class UnblockUserService extends TransactionAwareApplicationService
{
    /**
     * @var UserReadModelRepository
     */
    private $userReadModelRepository;

    public function __construct(
        UserReadModelRepository $userReadModelRepository,
        EntityManagerInterface $entityManager,
        WriteModelRepository $writeModelRepository
    )
    {
        parent::__construct($entityManager, $writeModelRepository);
        $this->userReadModelRepository = $userReadModelRepository;
    }

    /**
     * @param UserId $userId
     * @throws ConnectionException
     * @throws Throwable
     */
    public function execute(
        UserId $userId
    ): void
    {
        $this->beginTransaction();
        try {
            $user = $this->userReadModelRepository->findOrFailByUserId($userId);
            $user->unblock();
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
