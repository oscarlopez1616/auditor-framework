<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\IdentifiableDtoResource;

class PasswordRecoveryDtoResource extends IdentifiableDtoResource
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var bool
     */
    private $hasBeenUsed;

    /**
     * @var string
     */
    private $expirationDate;

    /**
     * @var bool
     */
    private $canBeUsedToChangePassword;

    public function __construct(
        string $id,
        string $createdAt,
        string $updatedAt,
        string $userId,
        bool $hasBeenUsed,
        string $expirationDate,
        bool $canBeUsedToChangePassword
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->userId = $userId;
        $this->hasBeenUsed = $hasBeenUsed;
        $this->expirationDate = $expirationDate;
        $this->canBeUsedToChangePassword = $canBeUsedToChangePassword;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function hasBeenUsed(): bool
    {
        return $this->hasBeenUsed;
    }

    public function expirationDate(): string
    {
        return $this->expirationDate;
    }

    public function canBeUsedToChangePassword(): bool
    {
        return $this->canBeUsedToChangePassword;
    }
}
