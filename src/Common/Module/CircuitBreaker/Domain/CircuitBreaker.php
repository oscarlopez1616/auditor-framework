<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain;

use function Lambdish\Phunctional\map;

class CircuitBreaker
{
    /**
     * @var CircuitBreakerId
     */
    private $id;

    /**
     * @var CircuitBreakerSupplier
     */
    private $circuitBreakerSupplier;


    private function __construct(CircuitBreakerId $id, CircuitBreakerSupplier $circuitBreakerSupplier)
    {
        $this->id = $id;
        $this->circuitBreakerSupplier = $circuitBreakerSupplier;
    }

    /**
     * @param CircuitBreakerId $id
     * @param CircuitBreakerSupplier[] $suppliersOrderByImportance
     * @return static
     */
    public static function circuitBreakerWithDefaultConfig(
        CircuitBreakerId $id,
        array $suppliersOrderByImportance
    ): self {

        $circuitBreakerSupplier = $suppliersOrderByImportance[0];
        unset($suppliersOrderByImportance[0]);

        map(
            function (CircuitBreakerSupplier $currentCircuitBreakerSupplier) use ($circuitBreakerSupplier): void {

                $onOpenCircuitSupplier = $currentCircuitBreakerSupplier;

                $circuitBreakerSupplier->setOnOpenCircuitSupplier($onOpenCircuitSupplier);
            }
            ,
            $suppliersOrderByImportance
        );

        $circuitBreaker = new self(
            $id,
            $circuitBreakerSupplier
        );

        return $circuitBreaker;
    }


    public function id(): CircuitBreakerId
    {
        return $this->id;
    }

    public function circuitBreakerSupplier(): CircuitBreakerSupplier
    {
        return $this->circuitBreakerSupplier;
    }

}
