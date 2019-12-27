<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword;

use AuditorFramework\Common\Types\Application\ApplicationService;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryReadModelRepository;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;

class GetPasswordRecoveryService implements ApplicationService
{
    /**
     * @var PasswordRecoveryReadModelRepository
     */
    private $passwordRecoveryReadModelRepository;

    /**
     * @var UserReadModelRepository
     */
    private $userReadModelRepository;

    public function __construct(
        PasswordRecoveryReadModelRepository $passwordRecoveryReadModelRepository,
        UserReadModelRepository $userReadModelRepository
    ) {
        $this->passwordRecoveryReadModelRepository = $passwordRecoveryReadModelRepository;
        $this->userReadModelRepository = $userReadModelRepository;
    }

    public function execute(PasswordRecoveryId $passwordRecoveryId, UserId $userId): array
    {
        return [
            'passwordRecovery' => $this->passwordRecoveryReadModelRepository->findOrFailById($passwordRecoveryId),
            'user' => $this->userReadModelRepository->findOrFailByUserId($userId)
        ];
    }
}
