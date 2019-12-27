<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class MerchantIdInLenderContextControllerVoter extends ControllerVoter
{
    public const POST_CREATE_MERCHANT_ID_IN_LENDER_CONTEXT = 'post_create_merchant_id_in_lender_context';
    public const GET_MERCHANT_IN_LENDER_CONTEXT_BY_ID = 'get_merchant_in_lender_context_by_id';
    public const GET_MERCHANT_IN_LENDER_CONTEXT_BY_MERCHANT_ID_AND_LENDER_ID = 'get_merchant_in_lender_context_by_merchant_id_and_lender_id';

    private const ALLOWED_VALUES = [
        self::POST_CREATE_MERCHANT_ID_IN_LENDER_CONTEXT,
        self::GET_MERCHANT_IN_LENDER_CONTEXT_BY_ID,
        self::GET_MERCHANT_IN_LENDER_CONTEXT_BY_MERCHANT_ID_AND_LENDER_ID
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::POST_CREATE_MERCHANT_ID_IN_LENDER_CONTEXT => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK)
            ],
            self::GET_MERCHANT_IN_LENDER_CONTEXT_BY_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK)
            ],
            self::GET_MERCHANT_IN_LENDER_CONTEXT_BY_MERCHANT_ID_AND_LENDER_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK)
            ]
        ];
    }
}
