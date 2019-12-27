<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUserId;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\Query;

class GetUserByUserIdQuery implements Query
{
    /**
     * @var string
     */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

}
