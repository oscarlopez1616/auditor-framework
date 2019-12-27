<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\NonIdentifiableDtoResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\NonIdentifiableRestResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\NonIdentifiableRestResourceCollection;

class NonIdentifiableDtoResourceToRestResourceDataTransformer
{
    public function transform(
        NonIdentifiableDtoResource $nonIdentifiableDtoResource,
        array $namespaces
    ): NonIdentifiableRestResource {

        return new NonIdentifiableRestResource($nonIdentifiableDtoResource, $namespaces);
    }

    /**
     * @param NonIdentifiableDtoResource[] $nonIdentifiableDtoResources
     * @param array $namespaces
     * @return NonIdentifiableRestResourceCollection
     */
    public function transformFromNonIdentifiableDtoResources(
        array $nonIdentifiableDtoResources,
        array $namespaces
    ): NonIdentifiableRestResourceCollection {

        $nonIdentifiableRestResourceCollection = new NonIdentifiableRestResourceCollection();

        foreach ($nonIdentifiableDtoResources as $nonIdentifiableDtoResource) {
            $nonIdentifiableRestResourceCollection->addNonIdentifiableRestResource($this->transform($nonIdentifiableDtoResource, $namespaces));
        }

        return $nonIdentifiableRestResourceCollection;
    }
}
