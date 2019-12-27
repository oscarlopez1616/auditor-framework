<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception;

abstract class InvalidDomainFormatException extends DomainException
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
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
