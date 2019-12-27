<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Service;

use Doctrine\Common\Collections\Collection;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;

class ValueObjectCollectionService
{
    public static function equals(Collection $voCollection, Collection $anotherVoCollection): bool
    {
        /** @var ValueObject $valueObjectToCompare */
        foreach ($anotherVoCollection as $valueObjectToCompare) {
            /** @var ValueObject $valueObject */
            foreach ($voCollection as $valueObject) {
                if ($valueObject->equals($valueObjectToCompare)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function contains(ValueObject $valueObject, Collection $voCollection): bool
    {
        return $voCollection->exists(
            function($key, $currentVo) use ($valueObject) { return $valueObject->equals($currentVo);}
        );
    }
}
