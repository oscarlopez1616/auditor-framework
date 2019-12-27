<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class MerchantAttributionControllerVoter extends ControllerVoter
{
    public const GET_MERCHANT_ATTRIBUTION_BY_MERCHANT_ID = 'get_merchant_attribution_by_merchant_id';
    public const POST_MERCHANT_ATTRIBUTION = 'post_merchant_attribution';

    private const ALLOWED_VALUES = [
        self::GET_MERCHANT_ATTRIBUTION_BY_MERCHANT_ID,
        self::POST_MERCHANT_ATTRIBUTION
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_MERCHANT_ATTRIBUTION_BY_MERCHANT_ID => [
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK)
            ],
            self::POST_MERCHANT_ATTRIBUTION => [
                new Role(Role::ROLE_FRONTEND_LANDING)
            ],
        ];
    }
}
