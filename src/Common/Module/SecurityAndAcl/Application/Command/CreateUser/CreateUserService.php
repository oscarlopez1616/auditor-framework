<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\CreateUser;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\Exception\TransactionalApplicationException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\TransactionAwareApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\WriteModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\TrikoderOauth2\OauthClientService;
use Throwable;

class CreateUserService extends TransactionAwareApplicationService
{
    /**
     * @var UserReadModelRepository
     */
    private $userReadModelRepository;
    /**
     * @var OauthClientService
     */
    private $oauthClientService;

    public function __construct(
        UserReadModelRepository $userReadModelRepository,
        OauthClientService $oauthClientService,
        EntityManager $entityManager,
        WriteModelRepository $writeModelRepository
    ) {
        $this->userReadModelRepository = $userReadModelRepository;
        $this->oauthClientService = $oauthClientService;
        parent::__construct($entityManager, $writeModelRepository);
    }


    /**
     * @param User $user
     *
     * @throws ConnectionException
     * @throws Throwable
     */
    public function execute(User $user): void
    {
        $this->beginTransaction();
        try {
            $this->userReadModelRepository->save($user);
            $this->oauthClientService->create($user->id()->value(), md5($user->getUsername()));
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
