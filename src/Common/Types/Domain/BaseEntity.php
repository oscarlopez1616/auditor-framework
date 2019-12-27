<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use DateTime;
use DateTimeImmutable;

abstract class BaseEntity
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * @return Id
     */
    abstract public function id();

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
