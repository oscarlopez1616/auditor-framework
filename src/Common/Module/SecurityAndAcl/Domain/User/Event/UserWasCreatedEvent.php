<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserType;

class UserWasCreatedEvent extends Event
{

    /**
     * @var UniqueEmail
     */
    private $userName;

    /**
     * @var Role[]
     */
    private $roles;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var UserType
     */
    private $userType;


    public function __construct(
        UserId $id,
        UniqueEmail
        $userMerchantGroupId,
        array $roles,
        string $password,
        bool $active,
        UserType $userType
    )
    {
        $this->userName = $userMerchantGroupId;
        $this->roles = $roles;
        $this->password = $password;
        $this->active = $active;
        $this->userType = $userType;
        parent::__construct($id);
    }


    protected function getIdClass(): string
    {
        return UserId::class;
    }

    /**
     * @throws Exception
     */
    protected function internalUnSerialize(): void
    {
        $payload = $this->payload();

        $this->userName = new UniqueEmail(
            $payload['user_name']
        );

        foreach ($payload['roles'] as $role) {
            $this->roles[] = new Role($role);
        }

        $this->password = $payload['password'];

        $this->active = $payload['active'];

        $this->userType = new UserType($payload['user_type']);
    }

    public function internalSerialize(): array
    {
        $payload = [
            'user_name' => $this->userName->value(),
            'password' => $this->password,
            'active' => $this->active,
            'user_type' => $this->userType->userType()
        ];
        foreach ($this->roles as $role) {
            $payload['roles'][]= $role->value();
        }
        return $payload;
    }

    /**
     * @return UniqueEmail
     */
    public function userName(): UniqueEmail
    {
        return $this->userName;
    }

    /**
     * @return Role[]
     */
    public function roles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function active(): bool
    {
        return $this->active;
    }

    /**
     * @return UserType
     */
    public function userType(): UserType
    {
        return $this->userType;
    }
}
