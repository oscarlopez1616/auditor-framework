<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\ApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;

class GetUserIdByUsernameService implements ApplicationService
{
    /**
     * @var UserReadModelRepository
     */
    private $userReadModelRepository;

    public function __construct(
        UserReadModelRepository $userReadModelRepository
    ) {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    public function execute(UniqueEmail $userName): User
    {
        return $this->userReadModelRepository->findOrFailByUserName($userName);
    }
}
