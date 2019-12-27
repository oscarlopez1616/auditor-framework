<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\Query;

class GetPasswordRecoveryQuery implements Query
{
    /**
     * @var string
     */
    private $passwordRecoveryId;

    /**
     * @var string
     */
    private $userId;

    public function __construct(string $passwordRecoveryId, string $userId)
    {
        $this->passwordRecoveryId = $passwordRecoveryId;
        $this->userId = $userId;
    }

    public function passwordRecoveryId(): string
    {
        return $this->passwordRecoveryId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
