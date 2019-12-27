<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\DataTransformer;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\InvalidUuidClassException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;

class UuIdsToArrayDataTransformer
{
    /**
     * @param Uuid[] $uuIds
     *
     * @return array
     */
    public static function transform(array $uuIds): array
    {
        $uuIdsArr = [];
        foreach ($uuIds as $uuId) {
            $uuIdsArr[]= $uuId->value();
        }

        return $uuIdsArr;
    }

    /**
     * @param array $uuIdsArray
     * @param string $uuIdClassName
     * @return Uuid[]
     */
    public static function reverseTransform(array $uuIdsArray, string $uuIdClassName): array
    {
        if (!class_exists($uuIdClassName) || !is_subclass_of($uuIdClassName, Uuid::class)) {
            throw new InvalidUuidClassException("Given Uuid name is not a valid class: $uuIdClassName");
        }

        $uuIds = [];
        foreach ($uuIdsArray as $uuidScalar) {
            $uuIds[]= new $uuIdClassName($uuidScalar);
        }

        return $uuIds;
    }
}
