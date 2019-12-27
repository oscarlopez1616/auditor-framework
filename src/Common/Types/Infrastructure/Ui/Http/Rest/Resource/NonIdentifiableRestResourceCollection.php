<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\NonIdentifiableDtoResource;

final class NonIdentifiableRestResourceCollection extends RestResource implements RestResourceCollection
{
    /**
     * @var NonIdentifiableDtoResource[]
     */
    private $data;

    /**
     * NonIdentifiableRestResourceCollection constructor.
     * @param NonIdentifiableDtoResource[] $nonIdentifiableRestResources
     */
    public function __construct(array $nonIdentifiableRestResources = [])
    {
        parent::__construct("ok");
        $this->data = $nonIdentifiableRestResources;
    }

    public function addNonIdentifiableRestResource(NonIdentifiableRestResource $nonIdentifiableRestResource) {
        array_push($this->data, $nonIdentifiableRestResource);
    }
}
