<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

abstract class ValueObject
{
    /**
     * @param ValueObject|self $o
     *
     * If you need to check a nullable ValueObject use this format
     * NullableObjectService::equalsValueObject(
     *  isset($this->balance) ? $this->balance : null,
     *  isset($o->balance) ? $o->balance : null
     * )
     *
     * @return bool
     */
    public function equals(ValueObject $o): bool
    {
        return get_class($this) === get_class($o) && $this->equalValues($o);
    }

    abstract protected function equalValues(ValueObject $o): bool;
}
