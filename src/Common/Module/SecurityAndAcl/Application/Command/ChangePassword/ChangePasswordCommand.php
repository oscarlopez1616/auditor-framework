<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ChangePassword;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;

class ChangePasswordCommand implements Command
{

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $oldPassword;

    /**
     * @var string
     */
    private $newPassword;

    public function __construct(string $userName, string $oldPassword, string $newPassword)
    {
        $this->userName = $userName;
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function oldPassword(): string
    {
        return $this->oldPassword;
    }

    public function newPassword(): string
    {
        return $this->newPassword;
    }
}
