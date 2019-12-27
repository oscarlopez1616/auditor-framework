<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception;

abstract class InvalidArgumentInfrastructureException extends InfrastructureException
{
    /**
     * @var mixed
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The \%s\ is an invalid \%s\ value', $this->value, $this->getName());
    }

    abstract protected function getName(): string;
}
