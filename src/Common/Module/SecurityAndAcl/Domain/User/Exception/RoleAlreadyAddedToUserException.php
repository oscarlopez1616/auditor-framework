<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainException;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

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
