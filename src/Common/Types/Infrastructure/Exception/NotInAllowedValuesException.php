<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Exception;

use AuditorFramework\Common\Types\Domain\Exception\DomainException;

class NotInAllowedValuesException extends DomainException
{
    /**
     * @var string
     */
    private $errorMessage;

    public function __construct(string $value, array $allowedValues)
    {
        $allowedValuesString = implode(', ', $allowedValues);
        $this->errorMessage = "Value: \\$value\\ not in AllowedValues: \\$allowedValuesString\\";

        parent::__construct();
    }


    protected function errorMessage(): string
    {
        return $this->errorMessage;
    }
}
