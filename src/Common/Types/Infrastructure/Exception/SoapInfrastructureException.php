<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

class SoapInfrastructureException extends InfrastructureException
{
    private $errorMessage;

    public function __construct(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;

        parent::__construct();
    }

    protected function errorMessage(): string
    {
       return sprintf('Soap error:\%s\\', $this->errorMessage);
    }
}
