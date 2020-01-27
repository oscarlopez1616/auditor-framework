<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class UserControllerVoter extends ControllerVoter
{
    public const GET_PASSWORD_RECOVERY = 'get_password_recovery';
    public const POST_USER = 'post_user';
    public const PROCESS_PATCH_ADD_ROLE_TO_USER = 'process_patch_add_role_to_user';
    public const PROCESS_PATCH_CHANGE_PASSWORD = 'process_patch_change_password';
    public const PROCESS_PATCH_FORGOT_PASSWORD_CREATE_AND_SEND_PASSWORD_RECOVERY =
        'process_patch_forgot_password_create_and_send_password_recovery';
    public const PROCESS_PATCH_BLOCK_USER = 'process_patch_block_user';
    public const PROCESS_PATCH_UNBLOCK_USER = 'process_patch_unblock_user';

    private const ALLOWED_VALUES = [
        self::GET_PASSWORD_RECOVERY,
        self::POST_USER,
        self::PROCESS_PATCH_ADD_ROLE_TO_USER,
        self::PROCESS_PATCH_CHANGE_PASSWORD,
        self::PROCESS_PATCH_FORGOT_PASSWORD_CREATE_AND_SEND_PASSWORD_RECOVERY,
        self::PROCESS_PATCH_BLOCK_USER,
        self::PROCESS_PATCH_UNBLOCK_USER,
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_PASSWORD_RECOVERY => [
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_FRONTEND_LANDING),
            ],
            self::POST_USER => [
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_BORROWER),
                new Role(Role::ROLE_FRONTEND_LANDING),
            ],
            self::PROCESS_PATCH_ADD_ROLE_TO_USER => [
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_BORROWER),
                new Role(Role::ROLE_FRONTEND_LANDING),
            ],
            self::PROCESS_PATCH_CHANGE_PASSWORD => [
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_BORROWER),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_FRONTEND_LANDING),
            ],
            self::PROCESS_PATCH_FORGOT_PASSWORD_CREATE_AND_SEND_PASSWORD_RECOVERY => [
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_BORROWER),
                new Role(Role::ROLE_FRONTEND_LANDING),
            ],
            self::PROCESS_PATCH_BLOCK_USER => [
                new Role(Role::ROLE_SUPER_ADMIN),
            ],
            self::PROCESS_PATCH_UNBLOCK_USER => [
                new Role(Role::ROLE_SUPER_ADMIN),
            ],
        ];
    }
}
