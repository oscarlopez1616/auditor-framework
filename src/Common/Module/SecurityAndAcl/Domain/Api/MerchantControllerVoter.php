<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class MerchantControllerVoter extends ControllerVoter
{
    public const GET_MERCHANT_BY_ID = 'get_merchant_by_id';
    public const GET_MERCHANT_BY_EMAIL = 'get_merchant_by_email';
    public const GET_LOANS_BY_MERCHANT_ID = 'get_loans_by_merchant_id';
    public const GET_MERCHANTS = 'get_merchants';
    public const POST_MERCHANT = 'post_merchant';
    public const PROCESS_PATCH_CHANGE_MERCHANT_STATUS_BY_MERCHANT_ID =
        'process_patch_change_merchant_status_by_merchant_id';
    public const PROCESS_PATCH_CHANGE_APPROVAL_STATUS_BY_MERCHANT_ID =
        'process_patch_change_approval_status_by_merchant_id';

    public const PROCESS_PATCH_CHANGE_SEGMENT_BY_MERCHANT_ID =
        'process_patch_change_approval_status_by_merchant_id';
    private const ALLOWED_VALUES = [
        self::GET_MERCHANT_BY_ID,
        self::GET_MERCHANT_BY_EMAIL,
        self::GET_LOANS_BY_MERCHANT_ID,
        self::GET_MERCHANTS,
        self::POST_MERCHANT,
        self::PROCESS_PATCH_CHANGE_MERCHANT_STATUS_BY_MERCHANT_ID,
        self::PROCESS_PATCH_CHANGE_APPROVAL_STATUS_BY_MERCHANT_ID,
        self::PROCESS_PATCH_CHANGE_SEGMENT_BY_MERCHANT_ID
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_MERCHANT_BY_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::GET_MERCHANT_BY_EMAIL => [
                new Role(Role::ROLE_MERCHANT)
            ],
            self::GET_LOANS_BY_MERCHANT_ID => [
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
            ],
            self::GET_MERCHANTS => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK)
            ],
            self::POST_MERCHANT => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK)
            ],
            self::PROCESS_PATCH_CHANGE_MERCHANT_STATUS_BY_MERCHANT_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::PROCESS_PATCH_CHANGE_APPROVAL_STATUS_BY_MERCHANT_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::PROCESS_PATCH_CHANGE_SEGMENT_BY_MERCHANT_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_COMMERCIAL)
            ]
        ];
    }
}
