<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Id;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;

abstract class DoctrineInfrastructureId extends GuidType
{
    abstract public function className(): string;

    /**
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return Id
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        if (null === $value) {
            return null;
        }

        $className = $this->className();

        return new $className($value);
    }

    /**
     * @param Id|string             $value
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value === null ? null : $value->value();
    }
}
