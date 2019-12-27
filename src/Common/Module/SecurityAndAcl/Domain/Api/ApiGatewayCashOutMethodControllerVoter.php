<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class ApiGatewayCashOutMethodControllerVoter extends ControllerVoter
{
    public const GET_CASH_OUT_METHOD_CREDIT_CARD_PREAUTHORIZE_WIDGET_ACTION =
        'get_cash_out_method_credit_card_preauthorize_widget_action';

    private const ALLOWED_VALUES = [
        self::GET_CASH_OUT_METHOD_CREDIT_CARD_PREAUTHORIZE_WIDGET_ACTION
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_CASH_OUT_METHOD_CREDIT_CARD_PREAUTHORIZE_WIDGET_ACTION =>[
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
        ];
    }
}
