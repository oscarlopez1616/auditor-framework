<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ForgotPassword\ChangePassword;

use AuditorFramework\Common\Types\Application\CommandBus\Command;

class ChangePasswordCommand implements Command
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $passwordRecoveryId;

    /**
     * @var string
     */
    private $newPassword;

    public function __construct(string $id, string $passwordRecoveryId, string $newPassword)
    {
        $this->id = $id;
        $this->passwordRecoveryId = $passwordRecoveryId;
        $this->newPassword = $newPassword;
    }

    public function passwordRecoveryId(): string
    {
        return $this->passwordRecoveryId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function newPassword(): string
    {
        return $this->newPassword;
    }
}
