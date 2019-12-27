<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class OriginationRiskValuesControllerVoter extends ControllerVoter
{
    public const GET_ORIGINATION_RISK_VALUES_BY_ID = 'get_origination_risk_values_by_id';
    public const POST_ORIGINATION_RISK_VALUES = 'post_origination_risk_values';

    private const ALLOWED_VALUES = [
        self::GET_ORIGINATION_RISK_VALUES_BY_ID,
        self::POST_ORIGINATION_RISK_VALUES,
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_ORIGINATION_RISK_VALUES_BY_ID => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_BORROWER),
            ],
            self::POST_ORIGINATION_RISK_VALUES => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_BORROWER),
            ]
        ];
    }
}
