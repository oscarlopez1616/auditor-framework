<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;

class InvalidOldPasswordException extends DomainException
{
    /**
     * @var string
     */
    private $messageError;

    public function __construct( string $oldPassword)
    {
        $this->messageError = "$oldPassword is and invalid password";
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return $this->messageError;
    }

}
