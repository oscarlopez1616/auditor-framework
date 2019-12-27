<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\InfrastructureException;

class FileNotFoundDomainException extends InfrastructureException
{
    private $errorMessage;

    public function __construct(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;

        parent::__construct();
    }

    protected function errorMessage(): string
    {
       return sprintf('The FileSystemAdapter request return this response:\%s\\', $this->errorMessage);
    }
}
