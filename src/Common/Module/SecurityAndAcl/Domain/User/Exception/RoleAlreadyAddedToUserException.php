<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

class RoleAlreadyAddedToUserException extends DomainException
{
    /**
     * @var string
     */
    private $errorMessage;

    public function __construct(Role $role, UserId $userId)
    {
        $this->errorMessage = "This Role: {$role->value()} is already assigned to User: {$userId->value()}";
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return $this->errorMessage;
    }
}
