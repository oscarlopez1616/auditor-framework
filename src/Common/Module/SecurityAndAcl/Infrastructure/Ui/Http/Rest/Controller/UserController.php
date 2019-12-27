<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Ui\Http\Rest\Controller;

use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Controller\Controller;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource\CommandRestResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion\InfrastructureAssertion;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\AddRoleToUser\AddRoleToUserCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\BlockUser\BlockUserCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ChangePassword\ChangePasswordCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\CreateUser\CreateUserCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ForgotPassword\ChangePassword\ChangePasswordCommand as ForgotPasswordChangePasswordCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\ForgotPassword\CreateAndSendPasswordRecovery\CreateAndSendPasswordRecoveryCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\UnblockUser\UnblockUserCommand;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword\GetPasswordRecoveryQuery;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\ForgotPassword\PasswordRecoveryDtoResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUserId\GetUserByUserIdDtoResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUserId\GetUserByUserIdQuery;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUsername\GetUserByUsernameDtoResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserByUsername\GetUserByUsernameQuery;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername\GetUserIdByUsernameDtoResource;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Query\UserIdByUsername\GetUserIdByUsernameQuery;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api\UserControllerVoter;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\PasswordRecoveryId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    private const ALLOWED_PATCH_OPERATIONS = [
        'processPatchAddRoleToUser',
        'processPatchChangePassword',
        'processPatchForgotPasswordChangePassword',
        'processPatchForgotPasswordCreateAndSendPasswordRecovery',
        'processPatchBlockUser',
        'processPatchUnblockUser',
    ];


    protected function namespaces(): array
    {
        return array('security-and-acl', 'user');
    }

    /**
     *
     * @Route("/password/{passwordRecoveryId}/{userName}", name="get_forgot_password", methods={"GET"})
     *
     * @param string $passwordRecoveryId
     * @param string $userId
     * @return JsonResponse
     * @throws Exception
     */
    public function getPasswordRecoveryAction(string $passwordRecoveryId, string $userId): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserControllerVoter::GET_PASSWORD_RECOVERY);

        InfrastructureAssertion::isUuid($passwordRecoveryId);
        InfrastructureAssertion::isUuid($userId);

        $query = new GetPasswordRecoveryQuery($passwordRecoveryId, $userId);

        /** @var PasswordRecoveryDtoResource $passwordRecoveryDtoResource */
        $passwordRecoveryDtoResource = $this->queryBus->dispatch($query);

        $identifiableRestResource = $this->identifiableDtoResourceToApiRestResourceDataTransformer->transform(
            $passwordRecoveryDtoResource,
            $this->namespaces()
        );

        return $this->buildResponseForGetRestOk($identifiableRestResource);
    }

    /**
     * @Route("/user_name/{username}/", name="user_id_by_username", methods={"GET"})
     *
     * @param string $username
     * @return JsonResponse
     * @throws Exception
     */
    public function getUserByUserName(string $username)
    {
        $query = new GetUserIdByUsernameQuery($username);

        /** @var GetUserIdByUsernameDtoResource $getUserIdByUsernameDtoResource */
        $getUserIdByUsernameDtoResource = $this->queryBus->dispatch($query);

        $identifiableRestResource = $this->identifiableDtoResourceToApiRestResourceDataTransformer->transform(
            $getUserIdByUsernameDtoResource,
            $this->namespaces()
        );

        return $this->buildResponseForGetRestOk($identifiableRestResource);

    }

    /**
     * @Route("/{userId}/", name="user_by_user_id", methods={"GET"})
     *
     * @param string $userId
     * @return JsonResponse
     * @throws Exception
     */
    public function getUserByUserId(string $userId)
    {
        $query = new GetUserByUserIdQuery($userId);

        /** @var GetUserByUserIdDtoResource $getUserByUserIdDtoResource */
        $getUserByUserIdDtoResource = $this->queryBus->dispatch($query);

        $identifiableRestResource = $this->identifiableDtoResourceToApiRestResourceDataTransformer->transform(
            $getUserByUserIdDtoResource,
            $this->namespaces()
        );

        return $this->buildResponseForGetRestOk($identifiableRestResource);

    }

    /**
     * @Route("/acl/profile", name="user_profile", methods={"GET"})
     *
     * @param UserInterface $user
     * @return JsonResponse
     * @throws Exception
     */
    public function getAclUser(UserInterface $user)
    {
        $query = new GetUserByUsernameQuery($user->getUsername());

        /** @var GetUserByUsernameDtoResource $getUserByUsernameDtoResource */
        $getUserByUsernameDtoResource = $this->queryBus->dispatch($query);

        $identifiableRestResource = $this->identifiableDtoResourceToApiRestResourceDataTransformer->transform(
            $getUserByUsernameDtoResource,
            $this->namespaces()
        );

        return $this->buildResponseForGetRestOk($identifiableRestResource);

    }

    /**
     * @Route("/", name="post_create_user_action", methods={"Post"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function postUserAction(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserControllerVoter::POST_USER);

        $data = json_decode($request->getContent(), true);

        InfrastructureAssertion::keyExists($data, 'id');
        InfrastructureAssertion::keyExists($data, 'user_name');
        InfrastructureAssertion::keyExists($data, 'roles');
        InfrastructureAssertion::keyExists($data, 'password');
        InfrastructureAssertion::keyExists($data, 'active');
        InfrastructureAssertion::keyExists($data, 'user_type');

        InfrastructureAssertion::isUuid($data['id']);
        InfrastructureAssertion::notEmptyString($data['user_name']);
        InfrastructureAssertion::isArray($data['roles']);
        InfrastructureAssertion::notEmptyString($data['password']);
        InfrastructureAssertion::isBoolean($data['active']);
        InfrastructureAssertion::notEmptyString($data['user_type']);

        $command = new CreateUserCommand(
            $data['id'],
            $data['user_name'],
            $data['roles'],
            $data['password'],
            $data['active'],
            $data['user_type']
        );

        $this->commandBus->dispatch($command);

        $commandRestResource = new CommandRestResource($this->namespaces(), $data['id']);

        return $this->buildResponseForPostOk($commandRestResource);
    }


    /**
     * @uses processPatchAddRoleToUser
     * @uses processPatchChangePassword
     * @uses processPatchForgotPasswordChangePassword
     * @uses processPatchForgotPasswordCreateAndSendPasswordRecovery
     * @uses processPatchBlockUser
     * @uses processPatchUnblockUser
     *
     * @Route("/", name="patch", methods={"PATCH"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function patchAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $op = $data['op'];

        if (!in_array($op, self::ALLOWED_PATCH_OPERATIONS)) {
            throw new BadRequestHttpException("Patch operation <$op> not allowed");
        }
        return $this->$op($data);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     * @throws Exception
     */
    private function processPatchAddRoleToUser(array $data): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserControllerVoter::PROCESS_PATCH_ADD_ROLE_TO_USER);

        InfrastructureAssertion::keyExists($data, 'id');
        InfrastructureAssertion::keyExists($data, 'role');

        InfrastructureAssertion::isUuid($data['id']);
        InfrastructureAssertion::notEmptyString($data['role']);

        $this->commandBus->dispatch(new AddRoleToUserCommand($data['id'], $data['role']));

        $commandRestResource = new CommandRestResource($this->namespaces(), $data['id']);

        return $this->buildResponseForPatchOk($commandRestResource);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     * @throws Exception
     */
    private function processPatchChangePassword(array $data): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserControllerVoter::PROCESS_PATCH_CHANGE_PASSWORD);

        InfrastructureAssertion::keyExists($data, 'user_name');
        InfrastructureAssertion::keyExists($data, 'old_password');
        InfrastructureAssertion::keyExists($data, 'new_password');

        InfrastructureAssertion::notEmptyString($data['user_name']);
        InfrastructureAssertion::notEmptyString($data['old_password']);
        InfrastructureAssertion::notEmptyString($data['new_password']);

        $this->commandBus->dispatch(
            new ChangePasswordCommand($data['user_name'], $data['old_password'], $data['new_password'])
        );

        $commandRestResource = new CommandRestResource($this->namespaces(), $data['user_name']);

        return $this->buildResponseForPatchOk($commandRestResource);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     * @throws Exception
     */
    private function processPatchForgotPasswordChangePassword(array $data): JsonResponse
    {
        InfrastructureAssertion::keyExists($data, 'id');
        InfrastructureAssertion::keyExists($data, 'password_recovery_id');
        InfrastructureAssertion::keyExists($data, 'new_password');

        InfrastructureAssertion::isUuid($data['id']);
        InfrastructureAssertion::isUuid($data['password_recovery_id']);
        InfrastructureAssertion::notEmptyString($data['new_password']);

        $this->commandBus->dispatch(
            new ForgotPasswordChangePasswordCommand($data['id'], $data['password_recovery_id'], $data['new_password'])
        );

        $commandRestResource = new CommandRestResource($this->namespaces(), $data['id']);

        return $this->buildResponseForPatchOk($commandRestResource);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     * @throws Exception
     */
    private function processPatchForgotPasswordCreateAndSendPasswordRecovery(array $data): JsonResponse
    {
        InfrastructureAssertion::keyExists($data, 'user_name');

        $passwordRecoveryId = PasswordRecoveryId::create()->value();

        $this->commandBus->dispatch(
            new CreateAndSendPasswordRecoveryCommand($passwordRecoveryId, $data['user_name'])
        );

        $commandRestResource = new CommandRestResource($this->namespaces(), $passwordRecoveryId);

        return $this->buildResponseForPatchOk($commandRestResource);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     * @throws Exception
     */
    private function processPatchBlockUser(array $data): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserControllerVoter::PROCESS_PATCH_BLOCK_USER);

        InfrastructureAssertion::keyExists($data, 'id');

        InfrastructureAssertion::isUuid($data['id']);

        $this->commandBus->dispatch(
            new BlockUserCommand($data['id'])
        );

        $commandRestResource = new CommandRestResource($this->namespaces(), $data['id']);

        return $this->buildResponseForPatchOk($commandRestResource);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     * @throws Exception
     */
    private function processPatchUnblockUser(array $data): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserControllerVoter::PROCESS_PATCH_UNBLOCK_USER);

        InfrastructureAssertion::keyExists($data, 'id');

        InfrastructureAssertion::isUuid($data['id']);

        $this->commandBus->dispatch(
            new UnblockUserCommand($data['id'])
        );

        $commandRestResource = new CommandRestResource($this->namespaces(), $data['id']);

        return $this->buildResponseForPatchOk($commandRestResource);
    }
}
