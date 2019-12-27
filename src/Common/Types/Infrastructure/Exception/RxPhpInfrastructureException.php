<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

class RxPhpInfrastructureException extends InfrastructureException
{
    private $errorMessage;

    public function __construct(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;

        parent::__construct();
    }

    protected function errorMessage(): string
    {
       return sprintf('RxPhp error:\%s\\', $this->errorMessage);
    }
}
