<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class CashOutMethodControllerVoter extends ControllerVoter
{
    public const POST_CASH_OUT_METHOD = 'post_cash_out_method';

    private const ALLOWED_VALUES = [
        self::POST_CASH_OUT_METHOD,
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::POST_CASH_OUT_METHOD => [new Role(Role::ROLE_BORROWER)],
        ];
    }
}
