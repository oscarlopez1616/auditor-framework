<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Event;

use DateTime;
use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

class PasswordRecoveryWasCreatedEvent extends Event
{
    /** @var UserId */
    private $userId;

    /** @var bool */
    private $hasBeenUsed;

    /** @var DateTime */
    private $expirationDate;

    /**
     * PasswordRecoveryWasCreatedEvent constructor.
     * @param PasswordRecoveryId $id
     * @param UserId $userId
     * @param bool $hasBeenUsed
     * @param DateTime $expirationDate
     */
    public function __construct(
        PasswordRecoveryId $id,
        UserId $userId,
        bool $hasBeenUsed,
        DateTime $expirationDate
    )
    {
        $this->userId = $userId;
        $this->hasBeenUsed = $hasBeenUsed;
        $this->expirationDate = $expirationDate;
        parent::__construct($id);
    }

    protected function getIdClass(): string
    {
        return PasswordRecoveryId::class;
    }

    /**
     * @throws Exception
     */
    protected function internalUnSerialize(): void
    {
        $payload = $this->payload;
        $this->userId = new UserId($payload['passwordRecovery']['userId']);
        $this->hasBeenUsed = $payload['passwordRecovery']['hasBeenUsed'];
        $this->expirationDate = new DateTime($payload['passwordRecovery']['expirationDate']);
    }

    public function internalSerialize(): array
    {
        return [
            'passwordRecovery' => [
                'userId' => $this->userId->value(),
                'hasBeenUsed' => $this->hasBeenUsed,
                'expirationDate' => $this->expirationDate->format(DATE_ATOM)
            ]
        ];
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return bool
     */
    public function hasBeenUsed(): bool
    {
        return $this->hasBeenUsed;
    }

    /**
     * @return DateTime
     */
    public function expirationDate(): DateTime
    {
        return $this->expirationDate;
    }
}
