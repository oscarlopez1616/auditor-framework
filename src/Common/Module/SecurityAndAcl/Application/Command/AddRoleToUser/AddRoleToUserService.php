<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\AddRoleToUser;

use Doctrine\ORM\EntityManager;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\Exception\TransactionalApplicationException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\TransactionAwareApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;
use Throwable;

class AddRoleToUserService extends TransactionAwareApplicationService
{
    /**
     * @var UserReadModelRepository
     */
    private $userReadModelRepository;

    public function __construct(
        UserReadModelRepository $userReadModelRepository,
        EntityManager $entityManager,
        WriteModelRepository $writeModelRepository
    ) {
        parent::__construct($entityManager, $writeModelRepository);
        $this->userReadModelRepository = $userReadModelRepository;
    }

    /**
     * @param UserId $userId
     *
     * @param Role $role
     * @throws Throwable
     */
    public function execute(UserId $userId, Role $role): void
    {
        $this->beginTransaction();
        try {
            $user = $this->userReadModelRepository->findOrFailByUserId($userId);
            $user->addRoleToUser($role);
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
