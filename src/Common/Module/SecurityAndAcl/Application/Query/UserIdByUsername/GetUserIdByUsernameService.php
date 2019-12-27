<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername;

use AuditorFramework\Common\Types\Application\ApplicationService;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;

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
