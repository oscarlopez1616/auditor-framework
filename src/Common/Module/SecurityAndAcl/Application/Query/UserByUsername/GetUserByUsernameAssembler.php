<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUsername;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;

class GetUserByUsernameAssembler
{
    /**
     * @param User $user
     * @return GetUserByUsernameDtoResource
     * @throws Exception
     */
    public function toDto(User $user): GetUserByUsernameDtoResource
    {
        return new GetUserByUsernameDtoResource(
            $user->id()->value(),
            $user->createdAt()->format(DATE_ATOM),
            $user->updatedAt()->format(DATE_ATOM),
            $user->getUsername(),
            $user->userType()->userType(),
            $user->active()
        );
    }
}
