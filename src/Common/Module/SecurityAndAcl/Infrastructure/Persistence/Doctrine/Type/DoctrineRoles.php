<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class DoctrineRoles extends JsonType
{
    /**
     * @param string $value
     * @param AbstractPlatform $platform
     *
     * @return array
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        $roles = [];
        $rolesArr = json_decode($value, true);
        foreach ($rolesArr as $role) {
            array_push($roles, new Role($role));
        }
        return $roles;
    }

    /**
     * @param Role[] $values
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValue($values, AbstractPlatform $platform): string
    {
        $roles = [];
        foreach ($values as $value) {
            array_push($roles, $value->value());
        }
        return json_encode($roles);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
