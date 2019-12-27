<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\IdentifiableDtoResource;

class GetUserIdByUsernameDtoResource extends IdentifiableDtoResource
{
    public function __construct(
        string $id,
        string $createdAt,
        string $updatedAt
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
    }
}
