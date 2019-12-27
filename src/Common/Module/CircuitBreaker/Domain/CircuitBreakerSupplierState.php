<?php
declare(strict_types = 1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain;


class CircuitBreakerSupplierState
{
    public const OPEN = 'open';
    public const CLOSED = 'closed';
    public const HALF_OPEN = 'half_open';

    /**
     * @var string
     */
    private $value;

    /**
     * State constructor.
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function open(): self
    {
        return new self(CircuitBreakerSupplierState::OPEN);
    }

    public static function closed(): self
    {
        return new self(CircuitBreakerSupplierState::CLOSED);
    }

    public static function halfOpen(): self
    {
        return new self(CircuitBreakerSupplierState::HALF_OPEN);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

}
