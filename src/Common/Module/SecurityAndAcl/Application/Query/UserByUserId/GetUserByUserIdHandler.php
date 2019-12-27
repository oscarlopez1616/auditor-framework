<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUserId;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\Query;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\QueryBus\QueryHandler;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\UserId;
use React\Promise\Deferred;

class GetUserByUserIdHandler implements QueryHandler
{
    /**
     * @var GetUserByUserIdService
     */
    private $userProfileService;

    /**
     * @var GetUserByUserIdAssembler
     */
    private $getUserProfileAssembler;

    public function __construct(
        GetUserByUserIdService $userProfileService,
        GetUserByUserIdAssembler $forgotPasswordAssembler
    ) {
        $this->userProfileService = $userProfileService;
        $this->getUserProfileAssembler = $forgotPasswordAssembler;
    }

    /**
     * @param Query|GetUserByUserIdQuery $query
     * @param Deferred $deferred
     * @return mixed|void
     * @throws Exception
     */
    public function __invoke(Query $query, Deferred $deferred)
    {
        $userId = new UserId($query->userId());
        $user = $this->userProfileService->execute($userId);

        $deferred->resolve(
            $this->getUserProfileAssembler->toDto(
                $user
            )
        );
    }
}
