<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;

class GetUserIdByUsernameAssembler
{
    /**
     * @param User $user
     * @return GetUserIdByUsernameDtoResource
     * @throws Exception
     */
    public function toDto(User $user): GetUserIdByUsernameDtoResource
    {
        return new GetUserIdByUsernameDtoResource(
            $user->id()->value(),
            $user->createdAt()->format(DATE_ATOM),
            $user->updatedAt()->format(DATE_ATOM),
        );
    }
}
