<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Utils\FixNullableValueObjectsService;
use ReflectionException;

abstract class IdentifiableValueObject extends ValueObject
{
    /**
     * @var integer|null
     */
    protected $id = null;

    public function id(): ?int
    {
        return $this->id;
    }

    protected function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Hack to fix Doctrine Embeddeds
     * TODO: Fix when doctrine releases 3.0 version.
     * @throws ReflectionException
     */
    public function fixNullableDoctrineEmbeddables()
    {
        FixNullableValueObjectsService::execute($this);
    }
}
