<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery;

use DateInterval;
use DateTime;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AggregateRoot;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Event\PasswordRecoveryWasCreatedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Event\PasswordRecoveryWasUsedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;

class PasswordRecovery extends AggregateRoot
{
    private const DATE_INTERVAL_EXPIRATION_DATE = 'P3D';

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var bool
     */
    private $hasBeenUsed;

    /**
     * @var DateTime
     */
    private $expirationDate;

    public static function create(PasswordRecoveryId $id, UserId $userId): self
    {
        $passwordRecovery = new self();

        $passwordRecovery->recordThat(
            new PasswordRecoveryWasCreatedEvent(
                $id,
                $userId,
                false,
                (new DateTime())->add(new DateInterval(self::DATE_INTERVAL_EXPIRATION_DATE))
            )
        );

        return $passwordRecovery;
    }

    public function applyPasswordRecoveryWasCreatedEvent(PasswordRecoveryWasCreatedEvent $event): void
    {
        $this->id = $event->id();
        $this->userId = $event->userId();
        $this->hasBeenUsed = $event->hasBeenUsed();
        $this->expirationDate = $event->expirationDate();
        $this->createdAt = $event->createdAt();
        $this->updatedAt = $event->updatedAt();
    }

    public function use(): void
    {
        $this->recordThat(
            new PasswordRecoveryWasUsedEvent(
                $this->id(),
                true
            )
        );
    }

    public function applyPasswordRecoveryWasUsedEvent(PasswordRecoveryWasUsedEvent $event): void
    {
        $this->hasBeenUsed = $event->hasBeenUsed();
        $this->updatedAt = $event->updatedAt();
    }

    public function id(): PasswordRecoveryId
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function hasBeenUsed(): bool
    {
        return $this->hasBeenUsed;
    }

    public function expirationDate(): DateTime
    {
        return $this->expirationDate;
    }

    protected function getChildEntities(): array
    {
        return [];
    }

    public function canBeUsedToChangePassword(PasswordRecoveryId $passwordRecoveryId, UserId $userId): bool
    {
        return $this->id->equals($passwordRecoveryId) &&
            $this->userId->equals($userId) &&
            (new DateTime()) <= $this->expirationDate &&
            !$this->hasBeenUsed;
    }

    public function isValid(
        PasswordRecoveryId $passwordRecoveryId
    ): bool
    {
        return $this->id->equals($passwordRecoveryId) && !$this->hasBeenUsed && (new DateTime()) < $this->expirationDate;
    }
}
