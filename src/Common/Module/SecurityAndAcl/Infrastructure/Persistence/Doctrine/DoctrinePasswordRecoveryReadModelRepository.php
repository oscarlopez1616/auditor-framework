<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception\PasswordRecoveryAlreadyExistException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception\PasswordRecoveryNotFoundByIdException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecovery;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryReadModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

class DoctrinePasswordRecoveryReadModelRepository implements PasswordRecoveryReadModelRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param PasswordRecovery $passwordRecovery
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(PasswordRecovery $passwordRecovery): void
    {
        try {
            $this->entityManager->persist($passwordRecovery);
            $this->entityManager->flush($passwordRecovery);
        } catch (UniqueConstraintViolationException $e) {
            throw new PasswordRecoveryAlreadyExistException();
        }
    }

    public function findOrFailById(PasswordRecoveryId $passwordRecoveryId): PasswordRecovery
    {
        $passwordRecovery = $this->entityManager->getRepository(PasswordRecovery::class)->find($passwordRecoveryId);
        if (!$passwordRecovery instanceof PasswordRecovery) {
            throw new PasswordRecoveryNotFoundByIdException($passwordRecoveryId);
        }
        return $passwordRecovery;
    }

    public function findOrFailByUserId(UserId $userId): PasswordRecovery
    {
        $passwordRecovery = $this->entityManager->getRepository(PasswordRecovery::class)->findOneBy(array('userId' => $userId));
        if (!$passwordRecovery instanceof PasswordRecovery) {
            throw new PasswordRecoveryNotFoundByIdException($userId);
        }
        return $passwordRecovery;
    }

    public function findOrFailLastCreatedByUserId(UserId $userId): PasswordRecovery
    {
        $passwordRecovery = $this->entityManager->getRepository(PasswordRecovery::class)->findOneBy(array('userId' => $userId), array('createdAt' => 'DESC'));
        if (!$passwordRecovery instanceof PasswordRecovery) {
            throw new PasswordRecoveryNotFoundByIdException($userId);
        }
        return $passwordRecovery;
    }
}
