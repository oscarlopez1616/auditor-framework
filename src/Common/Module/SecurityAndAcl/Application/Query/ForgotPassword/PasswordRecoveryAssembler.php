<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecovery;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;

class PasswordRecoveryAssembler
{
    /**
     * @param PasswordRecovery $passwordRecovery
     * @param User $user
     * @return PasswordRecoveryDtoResource
     * @throws Exception
     */
    public function toDto(PasswordRecovery $passwordRecovery, User $user): PasswordRecoveryDtoResource
    {
        return new PasswordRecoveryDtoResource(
            $passwordRecovery->id()->value(),
            $passwordRecovery->createdAt()->format(DATE_ATOM),
            $passwordRecovery->updatedAt()->format(DATE_ATOM),
            $passwordRecovery->userId()->value(),
            $passwordRecovery->hasBeenUsed(),
            $passwordRecovery->expirationDate()->format(DATE_ATOM),
            $passwordRecovery->canBeUsedToChangePassword($passwordRecovery->id(), $user->id())
        );
    }
}
