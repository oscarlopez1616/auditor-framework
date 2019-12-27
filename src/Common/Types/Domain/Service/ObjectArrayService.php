<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Service;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;

class ObjectArrayService
{
    /**
     * @param ValueObject[] $voArray
     * @param ValueObject[] $anotherVoArray
     *
     * @return bool
     */
    public static function equalsValueObject(array $voArray, array $anotherVoArray): bool
    {
        foreach ($anotherVoArray as $valueObjectToCompare) {
            foreach ($voArray as $valueObject) {
                if (!$valueObject->equals($valueObjectToCompare)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param string[] $stringArray
     * @param string[] $anotherStringArray
     *
     * @return bool
     */
    public static function equalsString(array $stringArray, array $anotherStringArray): bool
    {
        foreach ($anotherStringArray as $stringToCompare) {
            foreach ($stringArray as $string) {
                if (!$string->equals($stringToCompare)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param ValueObject $valueObject
     * @param ValueObject[] $voCollection
     *
     * @return bool
     */
    public static function containsValueObject(ValueObject $valueObject, array $voCollection): bool
    {
        foreach ($voCollection as $voToCompare) {
            if ($valueObject->equals($voToCompare)) {
                return true;
            }
        }
        return false;
    }
}
