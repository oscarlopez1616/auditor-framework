<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUserId;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;

class GetUserByUserIdAssembler
{
    /**
     * @param User $user
     * @return GetUserByUserIdDtoResource
     * @throws Exception
     */
    public function toDto(User $user): GetUserByUserIdDtoResource
    {
        return new GetUserByUserIdDtoResource(
            $user->id()->value(),
            $user->createdAt()->format(DATE_ATOM),
            $user->updatedAt()->format(DATE_ATOM),
            $user->getUsername(),
            $user->userType()->userType(),
            $user->active()
        );
    }
}
