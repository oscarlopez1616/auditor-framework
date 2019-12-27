<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Utils;

use Doctrine\Common\Collections\AbstractLazyCollection;
use ReflectionClass;
use ReflectionException;

class FixNullableValueObjectsService
{
    /**
     * @param $object
     * @return bool
     * @throws ReflectionException
     */
    public static function execute($object): bool
    {
        if ($object !== null) {
            $reflectionObject = new ReflectionClass($object);
            $reflectionObjectProperties = $reflectionObject->getProperties();
            $totalObjectProperties = count($reflectionObjectProperties);
            $nullPropertiesFound = 0;

            foreach ($reflectionObjectProperties as $reflectionProperty) {

                $reflectionProperty->setAccessible(true);

                $currentPropertyValue = $reflectionProperty->getValue($object);

                if ($currentPropertyValue === null) {
                    $nullPropertiesFound++;
                }

                if ($currentPropertyValue instanceof AbstractLazyCollection && $currentPropertyValue->isInitialized()) {
                    foreach ($currentPropertyValue->getValues() as $value) {
                        if (is_object($value) && !$value instanceof AbstractLazyCollection) {
                            if (self::execute($value)) {
                                $nullPropertiesFound++;
                                $reflectionProperty->setAccessible(true);
                                $reflectionProperty->setValue($object, null);
                            }
                        }
                    }
                } elseif (is_object($currentPropertyValue) && !$currentPropertyValue instanceof AbstractLazyCollection) {
                    if (self::execute($currentPropertyValue)) {
                        $nullPropertiesFound++;
                        $reflectionProperty->setAccessible(true);
                        $reflectionProperty->setValue($object, null);
                    }
                }

                if ($totalObjectProperties > 0 && $nullPropertiesFound === $totalObjectProperties) {
                    return true;
                }
            }
        }
        return false;
    }
}
