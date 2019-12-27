<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application;

abstract class NonIdentifiableDtoResource
{
    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    public function __construct(string $createdAt, string $updatedAt)
    {
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function createdAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function updatedAt()
    {
        return $this->updatedAt;
    }

}
