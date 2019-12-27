<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUsername;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\Query;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\QueryHandler;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UniqueEmail;
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
