<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User;

use DateTime;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\RoleWasAddedToUserEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserPasswordWasChangedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserWasBlockedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserWasCreatedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserWasUnblockedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\RoleAlreadyAddedToUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use function Lambdish\Phunctional\map;

class User extends AggregateRoot implements UserInterface, ClientEntityInterface
{
    use ClientTrait, EntityTrait;

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

    /**
     * @var BlockControl
     */
    private $blockControl;

    public static function create(
        UserId $id,
        UniqueEmail $uniqueEmail,
        array $roles,
        string $password,
        bool $active,
        UserType $userType
    ): self {
        $user = new self();

        $user->recordThat(
            new UserWasCreatedEvent(
                $id,
                $uniqueEmail,
                $roles,
                $password,
                $active,
                $userType
            )
        );
        return $user;
    }

    protected function applyUserWasCreatedEvent(UserWasCreatedEvent $event): void
    {
        $this->id = $event->id();
        $this->userName = $event->userName();
        $this->roles = $event->roles();
        $this->password = $event->password();
        $this->active = $event->active();
        $this->userType = $event->userType();
        $this->blockControl = new BlockControl(
            false,
            null
        );
        $this->createdAt = $event->createdAt();
        $this->updatedAt = $event->updatedAt();
        $this->setIdentifier($event->userName());
    }

    public function addRoleToUser(Role $role): void
    {
        $roles = $this->roles;
        $roles[] = $role;

        $this->recordThat(
            new RoleWasAddedToUserEvent(
                $this->id(),
                $roles
            )
        );
    }

    public function applyRoleWasAddedToUserEvent(RoleWasAddedToUserEvent $event): void
    {
        $roles = $event->roles();
        $this->addRole(end($roles));
        $this->updatedAt = $event->updatedAt();
    }

    public function changePassword(string $newPassword): void
    {
        $this->recordThat(
            new UserPasswordWasChangedEvent(
                $this->id(),
                $newPassword
            )
        );
    }

    public function applyUserPasswordWasChangedEvent(UserPasswordWasChangedEvent $event): void
    {
        $this->password = $event->newPassword();
        $this->updatedAt = $event->updatedAt();
    }

    public function block(): void
    {
        $this->recordThat(
            new UserWasBlockedEvent(
                $this->id(),
                new BlockControl(
                    true,
                    (new DateTime())->format(DATE_ATOM)
                )
            )
        );
    }

    public function applyUserWasBlockedEvent(UserWasBlockedEvent $event): void
    {
        $this->blockControl = $event->blockControl();
    }

    public function unblock(): void
    {
        $this->recordThat(
            new UserWasUnblockedEvent(
                $this->id(),
                new BlockControl(
                    false,
                    null
                )
            )
        );
    }

    public function applyUserWasUnblockedEvent(UserWasUnblockedEvent $event): void
    {
        $this->blockControl = $event->blockControl();
    }

    protected function getChildEntities(): array
    {
        return [];
    }

    public function id(): UserId
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->id;
    }

    private function addRole(Role $role): void
    {
        if ($this->hasRole($role)) {
            throw new RoleAlreadyAddedToUserException($role, $this->id());
        }

        $this->roles[] = $role;
    }

    private function hasRole(Role $role): bool
    {
        return in_array($role, $this->roles);
    }

    public function isSuperAdmin(): bool
    {
        if ($this->hasRole(new Role(Role::ROLE_SUPER_ADMIN))) {
            return true;
        }

        return false;
    }

    public function isAdmin(): bool
    {
        if ($this->hasRole(new Role(Role::ROLE_ADMIN))) {
            return true;
        }

        return false;
    }

    public function matchAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    public function active(): bool
    {
        return $this->active;
    }

    public function getRoles(): array
    {
        return map(
            function (Role $role): string {
                return $role->value();
            }
            , $this->roles
        );
    }

    public function isValidPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername(): string
    {
        return $this->userName->value();
    }

    public function userType(): UserType
    {
        return $this->userType;
    }

    public function blockControl(): BlockControl
    {
        return $this->blockControl;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
