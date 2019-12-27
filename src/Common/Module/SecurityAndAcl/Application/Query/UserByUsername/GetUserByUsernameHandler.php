<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUsername;

use Exception;
use AuditorFramework\Common\Types\Application\QueryBus\Query;
use AuditorFramework\Common\Types\Application\QueryBus\QueryHandler;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use React\Promise\Deferred;

class GetUserByUsernameHandler implements QueryHandler
{
    /**
     * @var GetUserByUsernameService
     */
    private $userProfileService;

    /**
     * @var GetUserByUsernameAssembler
     */
    private $getUserProfileAssembler;

    public function __construct(
        GetUserByUsernameService $userProfileService,
        GetUserByUsernameAssembler $forgotPasswordAssembler
    ) {
        $this->userProfileService = $userProfileService;
        $this->getUserProfileAssembler = $forgotPasswordAssembler;
    }

    /**
     * @param Query|GetUserByUsernameQuery $query
     * @param Deferred $deferred
     * @return mixed|void
     * @throws Exception
     */
    public function __invoke(Query $query, Deferred $deferred)
    {
        $userName = new UniqueEmail($query->userName());
        $user = $this->userProfileService->execute($userName);

        $deferred->resolve(
            $this->getUserProfileAssembler->toDto(
                $user
            )
        );
    }
}
