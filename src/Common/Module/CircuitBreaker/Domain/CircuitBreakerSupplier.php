<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\CircuitBreaker\Domain;

use DateInterval;
use DateTime;
use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;

class CircuitBreakerSupplier
{
    /**
     * @var CircuitBreakerSupplierId
     */
    private $id;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var CircuitBreakerServiceType
     */
    private $serviceType;

    /**
     * @var int
     */
    private $threshold;

    /**
     * @var int
     */
    private $minimumRequests;

    /**
     * @var DateTime
     */
    private $timeWindow;

    /**
     * @var DateInterval
     */
    private $intervalToHalfOpen;

    /**
     * @var CircuitBreakerSupplierState
     */
    private $state;

    /**
     * @var CircuitBreakerSupplier|null
     */
    private $onOpenCircuitSupplier;


    /**
     * CircuitBreakerSupplier constructor.
     * @param CircuitBreakerSupplierId $id
     * @param string $endpoint
     * @param CircuitBreakerServiceType $serviceType
     * @param int $threshold
     * @param int $minimumRequests
     * @param DateTime $timeWindow
     * @param DateInterval $intervalToHalfOpen
     * @param CircuitBreakerSupplier|null $onOpenCircuitSupplier
     */
    public function __construct(
        CircuitBreakerSupplierId $id,
        string $endpoint,
        CircuitBreakerServiceType $serviceType,
        int $threshold,
        int $minimumRequests,
        DateTime $timeWindow,
        DateInterval $intervalToHalfOpen,
        ?CircuitBreakerSupplier $onOpenCircuitSupplier
    ) {
        $this->id = $id;
        $this->endpoint = $endpoint;
        $this->serviceType = $serviceType;
        $this->threshold = $threshold;
        $this->minimumRequests = $minimumRequests;
        $this->timeWindow = $timeWindow;
        $this->intervalToHalfOpen = $intervalToHalfOpen;
        $this->state = CircuitBreakerSupplierState::CLOSED;
        $this->onOpenCircuitSupplier = $onOpenCircuitSupplier;
    }

    /**
     * @param string $endpoint
     * @param CircuitBreakerServiceType $circuitBreakerServiceType
     * @return static
     * @throws Exception
     */
    public static function createSupplierWithDefaultParams(
        string $endpoint,
        CircuitBreakerServiceType $circuitBreakerServiceType
    ): self {

        return new self(
            new CircuitBreakerSupplierId(Uuid::create()),
            $endpoint,
            $circuitBreakerServiceType,
            3,
            2,
            new DateTime(),
            new DateInterval('6s'),
            null
        );
    }

    /**
     * @return CircuitBreakerSupplierId
     */
    public function id(): CircuitBreakerSupplierId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function endpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return CircuitBreakerServiceType
     */
    public function serviceType(): CircuitBreakerServiceType
    {
        return $this->serviceType;
    }

    /**
     * @return int
     */
    public function threshold(): int
    {
        return $this->threshold;
    }

    /**
     * @return int
     */
    public function minimumRequests(): int
    {
        return $this->minimumRequests;
    }

    /**
     * @return DateTime
     */
    public function timeWindow(): DateTime
    {
        return $this->timeWindow;
    }

    /**
     * @return DateInterval
     */
    public function intervalToHalfOpen(): DateInterval
    {
        return $this->intervalToHalfOpen;
    }

    /**
     * @return CircuitBreakerSupplierState
     */
    public function state(): CircuitBreakerSupplierState
    {
        return $this->state;
    }

    /**
     * @return CircuitBreakerSupplier|null
     */
    public function onOpenCircuitSupplier(): ?CircuitBreakerSupplier
    {
        return $this->onOpenCircuitSupplier;
    }


    public function setOnOpenCircuitSupplier(CircuitBreakerSupplier $circuitBreakerSupplier): void
    {
        $this->onOpenCircuitSupplier = $circuitBreakerSupplier;
    }
}

