<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Domain\User;

use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\UserAlreadyExistException;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\UserNotFoundByIdException;

interface UserReadModelRepository
{
    /**
     * @param User $user
     *
     * @throws UserAlreadyExistException
     */
    public function save(User $user): void;

    /**
     * @param UserId $userId
     *
     * @return User
     * @throws UserNotFoundByIdException
     */
    public function findOrFailByUserId(UserId $userId): User;

    /**
     * @param UniqueEmail $userName
     *
     * @return User
     * @throws UserNotFoundByIdException
     */
    public function findOrFailByUserName(UniqueEmail $userName): User;

}
