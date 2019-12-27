<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUsername;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\Query;

class GetUserByUsernameQuery implements Query
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
