<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUserId;

use AuditorFramework\Common\Types\Application\ApplicationService;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;

class GetUserByUserIdService implements ApplicationService
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

    public function execute(UserId $userId): User
    {
        return $this->userReadModelRepository->findOrFailByUserId($userId);
    }
}
