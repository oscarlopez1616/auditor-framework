<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class LenderControllerVoter extends ControllerVoter
{
    public const GET_LENDER_BY_ID = 'get_lender_by_id';
    public const GET_ALL_LENDERS = 'get_all_lenders';
    public const GET_LENDER_BY_NAME = 'get_lender_by_name';
    public const GET_LENDERS_IDS_BY_MERCHANT_ID = 'get_lenders_ids_by_merchant_id';
    public const POST_LENDER = 'post_lender';
    public const PROCESS_PATCH_ADD_MERCHANT_ID = 'process_patch_add_merchant_id';

    private const ALLOWED_VALUES = [
        self::GET_LENDER_BY_ID,
        self::GET_ALL_LENDERS,
        self::GET_LENDER_BY_NAME,
        self::GET_LENDERS_IDS_BY_MERCHANT_ID,
        self::POST_LENDER,
        self::PROCESS_PATCH_ADD_MERCHANT_ID
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_LENDER_BY_ID => [
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::GET_ALL_LENDERS => [
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::GET_LENDER_BY_NAME => [
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::GET_LENDERS_IDS_BY_MERCHANT_ID => [
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::PROCESS_PATCH_ADD_MERCHANT_ID => [
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::POST_LENDER => [
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ]
        ];
    }
}
