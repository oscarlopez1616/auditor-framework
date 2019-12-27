<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application;

abstract class IdentifiableDtoResource extends NonIdentifiableDtoResource
{
    /**
     * @var string
     */
    private $id;


    public function __construct(string $id, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        parent::__construct($createdAt, $updatedAt);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}
