<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\IdentifiableDtoResource;

final class IdentifiableRestResource extends RestResource
{
    use UrnTrait;

    /**
     * @var IdentifiableDtoResource
     */
    private $payload;

    /**
     * @param IdentifiableDtoResource $payload
     * @param string[]                $namespaces
     */
    public function __construct(IdentifiableDtoResource $payload, array $namespaces)
    {
        parent::__construct("ok");
        $this->buildIdentifier($namespaces, $payload->id());
        $this->payload = $payload;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

    public function payload(): IdentifiableDtoResource
    {
        return $this->payload;
    }

}
