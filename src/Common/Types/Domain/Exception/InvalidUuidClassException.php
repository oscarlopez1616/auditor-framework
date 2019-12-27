<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;

class InvalidUuidClassException extends DomainException
{
    /**
     * @var string
     */
    private $errorMessage;

    public function __construct(string $uuidClass)
    {
        $this->errorMessage = "This class $uuidClass is not a valid Uuid class";
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return $this->errorMessage;
    }
}
