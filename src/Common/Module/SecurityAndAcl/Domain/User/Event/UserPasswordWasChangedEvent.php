<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

class UserPasswordWasChangedEvent extends Event
{

    /** @var string */
    private $newPassword;

    /**
     * UserPasswordWasChangedEvent constructor.
     * @param UserId $id
     * @param string $newPassword
     */
    public function __construct(UserId $id, string $newPassword)
    {
        $this->newPassword = $newPassword;
        parent::__construct($id);
    }

    protected function getIdClass(): string
    {
        return UserId::class;
    }

    protected function internalUnSerialize(): void
    {
        $payload = $this->payload();

        $this->newPassword = $payload['newPassword'];
    }

    public function internalSerialize(): array
    {
        return [
            'newPassword' => $this->newPassword
        ];
    }

    /**
     * @return string
     */
    public function newPassword(): string
    {
        return $this->newPassword;
    }
}
