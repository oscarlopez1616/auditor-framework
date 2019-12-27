<?php
declare(strict_types = 1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain;

interface CircuitBreakerSupplierStorageManagerAdapter
{
    public function findOrFailCircuitBreakerById(CircuitBreakerSupplierId $id): CircuitBreakerSupplier;
    public function saveCircuitBreaker(CircuitBreakerSupplier $circuitBreakerSupplier);
}
