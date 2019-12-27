<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;

class CloudDocument extends ValueObject
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @var string
     */
    private $format;

    /**
     * bool
     */
    private $isPublic;

    /**
     * @var CloudDocumentType
     */
    private $cloudDocumentType;

    public function __construct(
        Uuid $uuid,
        string $format,
        CloudDocumentType $cloudDocumentType,
        bool $isPublic = false
    ) {
        $this->uuid = $uuid;
        $this->format = $format;
        $this->isPublic = $isPublic;
        $this->cloudDocumentType = $cloudDocumentType;
    }

    public function uuidAsString(): string
    {
        return $this->uuid->value();
    }

    public function format(): string
    {
        return $this->format;
    }

    public function isPublic() : bool
    {
        return $this->isPublic;
    }

    public function cloudDocumentType(): CloudDocumentType
    {
        return $this->cloudDocumentType;
    }

    public function path(): string
    {
        return sprintf('/%s/', $this->cloudDocumentType->value());
    }

    public function linkResource(): string
    {
        return $this->path().$this->uuid->value().".".$this->format;
    }

    /**
     * @param self|ValueObject $o
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->uuidAsString() === $o->uuidAsString()
            && $this->format() === $o->format()
            && $this->cloudDocumentType()->equals($o->cloudDocumentType())
            && $this->isPublic === $o->isPublic();
    }
}
