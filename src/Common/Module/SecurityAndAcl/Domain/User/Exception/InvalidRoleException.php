<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;

class InvalidRoleException extends DomainException
{
    /**
     * @var string
     */
    private $messageError;

    public function __construct( string $role)
    {
        $this->messageError = "An Error has occurred When role has been created with value: $role";
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return $this->messageError;
    }

}
