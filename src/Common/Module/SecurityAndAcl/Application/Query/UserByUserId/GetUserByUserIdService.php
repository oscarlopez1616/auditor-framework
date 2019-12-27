<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUserId;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\ApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\User;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;

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
