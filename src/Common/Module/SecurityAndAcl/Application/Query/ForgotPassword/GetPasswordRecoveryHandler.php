<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\Query;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\QueryHandler;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use React\Promise\Deferred;

class GetPasswordRecoveryHandler implements QueryHandler
{
    /**
     * @var GetPasswordRecoveryService
     */
    private $forgotPasswordService;

    /**
     * @var PasswordRecoveryAssembler
     */
    private $forgotPasswordAssembler;

    public function __construct(
        GetPasswordRecoveryService $forgotPasswordService,
        PasswordRecoveryAssembler $forgotPasswordAssembler
    ) {
        $this->forgotPasswordService = $forgotPasswordService;
        $this->forgotPasswordAssembler = $forgotPasswordAssembler;
    }

    /**
     * @param Query|GetPasswordRecoveryQuery $query
     * @param Deferred $deferred
     * @return mixed|void
     * @throws Exception
     */
    public function __invoke(Query $query, Deferred $deferred)
    {
        $passwordRecoveryId = new PasswordRecoveryId($query->passwordRecoveryId());
        $userId = new UserId($query->userId());
        $forgotPasswordResult = $this->forgotPasswordService->execute($passwordRecoveryId, $userId);
        $deferred->resolve(
            $this->forgotPasswordAssembler->toDto(
                $forgotPasswordResult['passwordRecovery'],
                $forgotPasswordResult['user']
            )
        );
    }
}
