<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\ApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryReadModelRepository;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserReadModelRepository;

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
