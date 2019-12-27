<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ForgotPassword\CreateAndSendPasswordRecovery;

use AuditorFramework\Common\Types\Application\CommandBus\Command;

class CreateAndSendPasswordRecoveryCommand implements Command
{

    /** @var string */
    private $passwordRecoveryId;

    /** @var string */
    private $userName;

    public function __construct(string $passwordRecoveryId, string $userName)
    {
        $this->passwordRecoveryId = $passwordRecoveryId;
        $this->userName = $userName;
    }

    public function passwordRecoveryId(): string
    {
        return $this->passwordRecoveryId;
    }

    public function userName(): string
    {
        return $this->userName;
    }
}
