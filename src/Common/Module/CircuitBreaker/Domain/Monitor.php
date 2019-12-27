<?php
declare(strict_types = 1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain;


class Monitor
{
    /**
     * @var CircuitBreakerSupplierId
     */
    private $id;

    /**
     * @var MonitorStat[]
     */
    private $monitorStats;

    /**
     * State constructor.
     * @param CircuitBreakerSupplierId $id
     * @param MonitorStat[] $monitorStats
     */
    public function __construct(CircuitBreakerSupplierId $id, array $monitorStats)
    {
        $this->id = $id;
        $this->monitorStats = $monitorStats;
    }

    /**
     * @return CircuitBreakerSupplierId
     */
    public function id(): CircuitBreakerSupplierId
    {
        return $this->id;
    }

    /**
     * @return MonitorStat[]
     */
    public function monitorStats(): array
    {
        return $this->monitorStats;
    }
}
