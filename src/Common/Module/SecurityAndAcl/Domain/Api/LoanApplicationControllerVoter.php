<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class LoanApplicationControllerVoter extends ControllerVoter
{
    public const GET_LOAN_APPLICATION_BY_ID = 'get_loan_application_by_id';
    public const GET_LOAN_APPLICATIONS_BY_IDS = 'get_loan_applications_by_ids';
    public const POST_LOAN_APPLICATIONS = 'post_loan_applications';
    public const PROCESS_PATCH_SET_MERCHANT_CASH_IN_CASH_OUT_METHOD_TO_LOAN = 'process_patch_set_merchant_cash_in_cash_out_method_to_loan';
    public const PROCESS_PATCH_SET_BORROWER_CASH_IN_CASH_OUT_METHOD_TO_LOAN = 'process_patch_set_borrower_cash_in_cash_out_method_to_loan';
    public const PROCESS_PATCH_SIGN_REQUEST_LOAN_LENDER_BORROWER_CONTRACT = 'process_patch_sign_request_loan_lender_borrower_contract';
    public const PROCESS_PATCH_SIGN_LOAN_LENDER_BORROWER_CONTRACT = 'process_patch_sign_loan_lender_borrower_contract';
    public const PROCESS_PATCH_PROCESS_LOAN_APPLICATION_IN_LENDER_MANUALLY = 'process_patch_process_loan_application_in_lender_manually';


    private const ALLOWED_VALUES = [
        self::GET_LOAN_APPLICATION_BY_ID,
        self::GET_LOAN_APPLICATIONS_BY_IDS,
        self::POST_LOAN_APPLICATIONS,
        self::PROCESS_PATCH_SET_MERCHANT_CASH_IN_CASH_OUT_METHOD_TO_LOAN,
        self::PROCESS_PATCH_SET_BORROWER_CASH_IN_CASH_OUT_METHOD_TO_LOAN,
        self::PROCESS_PATCH_SIGN_REQUEST_LOAN_LENDER_BORROWER_CONTRACT,
        self::PROCESS_PATCH_SIGN_LOAN_LENDER_BORROWER_CONTRACT,
        self::PROCESS_PATCH_PROCESS_LOAN_APPLICATION_IN_LENDER_MANUALLY,
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_LOAN_APPLICATION_BY_ID => [
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::GET_LOAN_APPLICATIONS_BY_IDS => [
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
            self::POST_LOAN_APPLICATIONS => [
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::PROCESS_PATCH_SET_MERCHANT_CASH_IN_CASH_OUT_METHOD_TO_LOAN => [
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::PROCESS_PATCH_SET_BORROWER_CASH_IN_CASH_OUT_METHOD_TO_LOAN => [
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::PROCESS_PATCH_SIGN_REQUEST_LOAN_LENDER_BORROWER_CONTRACT => [
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN),
            ],
            self::PROCESS_PATCH_SIGN_LOAN_LENDER_BORROWER_CONTRACT => [
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::PROCESS_PATCH_PROCESS_LOAN_APPLICATION_IN_LENDER_MANUALLY => [
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
        ];
    }
}
