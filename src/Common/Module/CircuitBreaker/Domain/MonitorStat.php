<?php
declare(strict_types = 1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain;


use DateTimeImmutable;

class MonitorStat
{
    /**
     * @var CircuitBreakerSupplierId
     */
    private $id;

    /**
     * @var bool
     */
    private $isAccessFailure;

    /**
     * @var DateTimeImmutable
     */
    private $dateTimeAccess;

    /**
     * MonitorStat constructor.
     * @param CircuitBreakerSupplierId $id
     * @param bool $isAccessFailure
     * @param DateTimeImmutable $dateTimeAccess
     */
    public function __construct(CircuitBreakerSupplierId $id, bool $isAccessFailure, DateTimeImmutable $dateTimeAccess)
    {
        $this->id = $id;
        $this->isAccessFailure = $isAccessFailure;
        $this->dateTimeAccess = $dateTimeAccess;
    }

    /**
     * @return CircuitBreakerSupplierId
     */
    public function id(): CircuitBreakerSupplierId
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isAccessFailure(): bool
    {
        return $this->isAccessFailure;
    }

    /**
     * @return DateTimeImmutable
     */
    public function dateTimeAccess(): DateTimeImmutable
    {
        return $this->dateTimeAccess;
    }
}
