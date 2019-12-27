<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

class RoleWasAddedToUserEvent extends Event
{
    /**
     * @var Role[]
     */
    private $roles;

    public function __construct(UserId $id, array $roles)
    {
        $this->roles = $roles;
        parent::__construct($id);
    }

    protected function getIdClass(): string
    {
        return UserId::class;
    }

    protected function internalUnSerialize(): void
    {
        $payload = $this->payload();

        $roles = [];

        foreach ($payload['user']['roles'] as $roleValue) {
            $roles[]= new Role($roleValue);
        }

        $this->roles = $roles;
    }

    public function internalSerialize(): array
    {
        $payload = ['user' => ['roles' => []]];

        foreach ($this->roles as $role) {
            $payload['user']['roles'][]= $role->value();
        }

        return $payload;
    }

    public function roles(): array
    {
        return $this->roles;
    }
}
