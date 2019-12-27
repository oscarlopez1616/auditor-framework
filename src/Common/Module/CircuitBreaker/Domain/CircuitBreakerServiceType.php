<?php
declare(strict_types = 1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain;


class CircuitBreakerServiceType
{
    public const REST = 'rest';
    public const SOAP = 'soap';

    /**
     * @var string
     */
    private $value;

    private function __construct(string $type)
    {
        $this->value = $type;
    }

    public static function rest():self
    {
        return new self(CircuitBreakerServiceType::REST);
    }

    public static function soap():self
    {
        return new self(CircuitBreakerServiceType::SOAP);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

}
