<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

final class IdentifiableRestResourceCollection extends RestResource implements RestResourceCollection
{
    /**
     * @var IdentifiableRestResource[]
     */
    private $data;

    public function __construct(array $nonIdentifiableRestResources = [])
    {
        parent::__construct("ok");
        $this->data = $nonIdentifiableRestResources;
    }

    public function addIdentifiableRestResource(IdentifiableRestResource $identifiableRestResource) {
        array_push($this->data,$identifiableRestResource);
    }
}
