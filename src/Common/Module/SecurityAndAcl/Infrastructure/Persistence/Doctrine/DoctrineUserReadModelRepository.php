<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\UserAlreadyExistException;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\UserNotFoundByIdException;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;
use AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\TrikoderOauth2\OauthClientService;

class DoctrineUserReadModelRepository implements UserReadModelRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var OauthClientService
     */
    private $oauthClientService;

    public function __construct(
        EntityManager $entityManager,
        OauthClientService $doctrineOauthClientRepository
    ) {
        $this->entityManager = $entityManager;
        $this->oauthClientService = $doctrineOauthClientRepository;
    }

    public function loadUserByUsername($username): User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(array('userName.value' => $username));
        if (!$user instanceof User) {
            throw new UserNotFoundByIdException();
        }
        return $user;
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush($user);
        } catch (UniqueConstraintViolationException $e) {
            throw new UserAlreadyExistException();
        }
    }

    public function findOrFailByUserId(UserId $userId): User
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('id' => $userId));
        if (!$user instanceof User) {
            throw new UserNotFoundByIdException($userId);
        }
        return $user;
    }

    public function findOrFailByUserName(UniqueEmail $userName): User
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['userName.value' => $userName->value()]);
        if (!$user instanceof User) {
            throw new UserNotFoundByIdException();
        }

        return $user;
    }
}
