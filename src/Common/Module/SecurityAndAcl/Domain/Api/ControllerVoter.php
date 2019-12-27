<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class ControllerVoter extends Voter
{
    protected function supports($attribute, $subject = null): bool
    {
        if (!in_array($attribute, $this->allowedValues())) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        if ($user->blockControl()->isBlocked()) {
            return false;
        }

        return $user->matchAnyRole($this->getAllowedRolesByAttributeMap()[$attribute]);
    }

    abstract protected function allowedValues(): array;

    abstract protected function getAllowedRolesByAttributeMap(): array;
}
