<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainException;

class InvalidPasswordRecoveryException extends DomainException
{
    /**
     * @var string
     */
    private $messageError;

    public function __construct( string $passwordRecovery)
    {
        $this->messageError = "$passwordRecovery is and invalid password recovery";
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return $this->messageError;
    }

}
