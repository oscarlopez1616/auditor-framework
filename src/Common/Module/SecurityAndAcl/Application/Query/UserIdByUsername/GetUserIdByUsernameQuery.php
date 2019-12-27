<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername;

use AuditorFramework\Common\Types\Application\QueryBus\Query;

class GetUserIdByUsernameQuery implements Query
{
    /**
     * @var string
     */
    private $userName;

    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    public function userName(): string
    {
        return $this->userName;
    }

}
