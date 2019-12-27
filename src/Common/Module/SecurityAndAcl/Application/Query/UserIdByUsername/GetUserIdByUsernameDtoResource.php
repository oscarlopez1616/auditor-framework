<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername;

use AuditorFramework\Common\Types\Application\IdentifiableDtoResource;

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
