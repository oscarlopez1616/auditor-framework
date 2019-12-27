<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

final class CommandRestResource extends RestResource
{
    use UrnTrait;

    public function __construct(array $namespaces, string $aResourceId)
    {
        parent::__construct('ok');
        $this->buildIdentifier($namespaces, $aResourceId);
    }
}
