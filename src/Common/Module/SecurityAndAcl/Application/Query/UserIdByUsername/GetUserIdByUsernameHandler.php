<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername;

use Exception;
use AuditorFramework\Common\Types\Application\QueryBus\Query;
use AuditorFramework\Common\Types\Application\QueryBus\QueryHandler;
use AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
use React\Promise\Deferred;

class GetUserIdByUsernameHandler implements QueryHandler
{
    /**
     * @var GetUserIdByUsernameService
     */
    private $userProfileService;

    /**
     * @var GetUserIdByUsernameAssembler
     */
    private $getUserIdByUsernameAssembler;

    public function __construct(
        GetUserIdByUsernameService $userProfileService,
        GetUserIdByUsernameAssembler $getUserIdByUsernameAssembler
    ) {
        $this->userProfileService = $userProfileService;
        $this->getUserIdByUsernameAssembler = $getUserIdByUsernameAssembler;
    }

    /**
     * @param Query|GetUserIdByUsernameQuery $query
     * @param Deferred $deferred
     * @return mixed|void
     * @throws Exception
     */
    public function __invoke(Query $query, Deferred $deferred)
    {
        $userName = new UniqueEmail($query->userName());
        $user = $this->userProfileService->execute($userName);

        $deferred->resolve(
            $this->getUserIdByUsernameAssembler->toDto(
                $user
            )
        );
    }
}
