<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUsername;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\IdentifiableDtoResource;

class GetUserByUsernameDtoResource extends IdentifiableDtoResource
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $role;

    /**
     * @var bool
     */
    private $active;

    public function __construct(
        string $id,
        string $createdAt,
        string $updatedAt,
        string $username,
        string $role,
        bool $active
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->username = $username;
        $this->role = $role;
        $this->active = $active;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function role(): string
    {
        return $this->role;
    }

    public function active(): bool
    {
        return $this->active;
    }
}
