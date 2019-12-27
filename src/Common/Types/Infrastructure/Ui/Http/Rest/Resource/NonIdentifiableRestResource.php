<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\NonIdentifiableDtoResource;

final class NonIdentifiableRestResource extends RestResource
{
    use UrnTrait;

    /**
     * @var NonIdentifiableDtoResource
     */
    private $payload;

    /**
     * @param NonIdentifiableDtoResource $payload
     * @param string[]                $namespaces
     */
    public function __construct(NonIdentifiableDtoResource $payload, array $namespaces)
    {
        parent::__construct("ok");
        $this->buildIdentifier($namespaces);
        $this->payload = $payload;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

    public function payload(): NonIdentifiableDtoResource
    {
        return $this->payload;
    }

}
