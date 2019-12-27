<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception\PasswordRecoveryAlreadyExistException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

interface PasswordRecoveryReadModelRepository
{
    /**
     * @param PasswordRecovery $passwordRecovery
     * @throws PasswordRecoveryAlreadyExistException
     */
    public function save(PasswordRecovery $passwordRecovery): void;

    /**
     * @param PasswordRecoveryId $passwordRecoveryId
     *
     * @return PasswordRecovery
     * @throws PasswordRecoveryAlreadyExistException
     */
    public function findOrFailById(PasswordRecoveryId $passwordRecoveryId): PasswordRecovery;

    /**
     * @param UserId $userId
     *
     * @return PasswordRecovery
     * @throws PasswordRecoveryAlreadyExistException
     */
    public function findOrFailByUserId(UserId $userId): PasswordRecovery;

    /**
     * @param UserId $userId
     *
     * @return PasswordRecovery
     * @throws PasswordRecoveryAlreadyExistException
     */
    public function findOrFailLastCreatedByUserId(UserId $userId): PasswordRecovery;
}
