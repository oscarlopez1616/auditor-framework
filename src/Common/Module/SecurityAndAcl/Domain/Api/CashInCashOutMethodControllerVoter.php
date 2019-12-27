<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class CashInCashOutMethodControllerVoter extends ControllerVoter
{
    public const PATCH_ADD_MERCHANT_CASH_IN_CASH_OUT_METHOD = 'patch_add_merchant_cash_in_cash_out_method';
    public const PATCH_ADD_BORROWER_CASH_IN_CASH_OUT_METHOD = 'patch_add_borrower_cash_in_cash_out_method';

    private const ALLOWED_VALUES = [
        self::PATCH_ADD_MERCHANT_CASH_IN_CASH_OUT_METHOD,
        self::PATCH_ADD_BORROWER_CASH_IN_CASH_OUT_METHOD,
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::PATCH_ADD_MERCHANT_CASH_IN_CASH_OUT_METHOD => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::PATCH_ADD_BORROWER_CASH_IN_CASH_OUT_METHOD => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN)
            ],
        ];
    }
}
