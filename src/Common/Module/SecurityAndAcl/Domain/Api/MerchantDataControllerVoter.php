<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class MerchantDataControllerVoter extends ControllerVoter
{
    public const POST_CREATE_MERCHANT_DATA = 'post_create_merchant_data';

    private const ALLOWED_VALUES = [
        self::POST_CREATE_MERCHANT_DATA
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::POST_CREATE_MERCHANT_DATA => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ]
        ];
    }
}
