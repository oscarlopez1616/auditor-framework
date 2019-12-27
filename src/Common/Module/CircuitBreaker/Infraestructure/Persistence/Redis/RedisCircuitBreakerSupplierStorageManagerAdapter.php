<?php


namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Infraestructure\Persistence\Redis;


use TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain\CircuitBreakerSupplier;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain\CircuitBreakerSupplierId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain\CircuitBreakerSupplierStorageManagerAdapter;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class RedisCircuitBreakerSupplierStorageManagerAdapter implements CircuitBreakerSupplierStorageManagerAdapter
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * RedisStateStorageManagerAdapter constructor.
     * @param AdapterInterface $cache
     */
    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param CircuitBreakerSupplierId $id
     * @return CircuitBreakerSupplier
     * @throws InvalidArgumentException
     */
    public function findOrFailCircuitBreakerById(CircuitBreakerSupplierId $id): CircuitBreakerSupplier
    {
        return unserialize($this->cache->getItem($id)->get());
    }

    /**
     * @param CircuitBreakerSupplier $circuitBreakerSupplier
     * @throws InvalidArgumentException
     */
    public function saveCircuitBreaker(CircuitBreakerSupplier $circuitBreakerSupplier)
    {
        $cacheItem = $this->cache->getItem($circuitBreakerSupplier->id());
        $this->cache->save(
            $cacheItem->set(serialize($circuitBreakerSupplier))
        );
    }

}
