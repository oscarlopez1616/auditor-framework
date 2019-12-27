<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Event;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;

class PasswordRecoveryWasUsedEvent extends Event
{
    /** @var bool */
    private $hasBeenUsed;

    /**
     * PasswordRecoveryWasDisabled constructor.
     * @param PasswordRecoveryId $id
     * @param bool $hasBeenUsed
     */
    public function __construct(PasswordRecoveryId $id, bool $hasBeenUsed)
    {
        $this->hasBeenUsed = $hasBeenUsed;
        parent::__construct($id);
    }

    protected function getIdClass(): string
    {
        return PasswordRecoveryId::class;
    }

    protected function internalUnSerialize(): void
    {
        $payload = $this->payload();
        $this->hasBeenUsed = boolval($payload['has_been_used']);
    }

    public function internalSerialize(): array
    {
       return [
           'has_been_used' => $this->hasBeenUsed
       ];
    }

    /**
     * @return bool
     */
    public function hasBeenUsed(): bool
    {
        return $this->hasBeenUsed;
    }
}
