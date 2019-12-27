<?php
declare(strict_types = 1);

namespace AuditorFramework\Common\Module\CircuitBreaker\Domain;


interface MonitorAdapter
{
    public function findOrFailMonitorByCircuitBreakerSupplierId(CircuitBreakerSupplierId $circuitBreakerSupplierId): Monitor;
    public function saveMonitor(Monitor $monitor);
}
