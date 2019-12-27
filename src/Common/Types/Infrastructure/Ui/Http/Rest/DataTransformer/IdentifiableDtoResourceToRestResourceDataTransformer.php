<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\DataTransformer;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\IdentifiableDtoResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\IdentifiableRestResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\IdentifiableRestResourceCollection;

class IdentifiableDtoResourceToRestResourceDataTransformer
{
    public function transform(
        IdentifiableDtoResource $identifiableDtoResource,
        array $namespaces
    ): IdentifiableRestResource {

        return new IdentifiableRestResource($identifiableDtoResource, $namespaces);
    }

    /**
     * @param IdentifiableDtoResource[] $identifiableDtoResources
     * @param array $namespaces
     * @return IdentifiableRestResourceCollection
     */
    public function transformFromIdentifiableDtoResources(
        array $identifiableDtoResources,
        array $namespaces
    ): IdentifiableRestResourceCollection {

        $identifiableRestResourceCollection = new IdentifiableRestResourceCollection();

        foreach ($identifiableDtoResources as $identifiableDtoResource) {
            $identifiableRestResourceCollection->addIdentifiableRestResource($this->transform($identifiableDtoResource, $namespaces));
        }

        return $identifiableRestResourceCollection;
    }
}
