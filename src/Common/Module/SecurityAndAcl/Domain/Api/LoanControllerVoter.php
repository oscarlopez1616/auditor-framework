<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class LoanControllerVoter extends ControllerVoter
{
    public const GET_LOAN_BY_ID = 'get_loan_by_id';
    public const GET_LOAN_CALCULATOR = 'get_loan_calculator';
    public const GET_LOANS_ACTION = 'get_loans_action';
    public const GET_SELECTED_LOAN_APPLICATION_BY_ID = 'get_selected_loan_application_by_id';
    public const POST_LOAN = 'post_loan';
    public const PROCESS_PATCH_CREATE_LOAN_ASSET_WITH_DECLARED_WORK_SITE_ADDRESS =
        'process_patch_create_loan_asset_with_declared_work_site_address';
    public const PROCESS_PATCH_CREATE_LOAN_ASSET_WITH_FORMATTED_WORK_SITE_ADDRESS =
        'process_patch_create_loan_asset_with_formatted_work_site_address';
    public const PROCESS_PATCH_ADD_INITIAL_LOAN_ASSET_STEP = 'process_patch_add_initial_loan_asset_step';
    public const PROCESS_PATCH_ADD_NON_INITIAL_LOAN_ASSET_STEP = 'process_patch_add_non_initial_loan_asset_step';
    public const PROCESS_PATCH_SET_INITIAL_LOAN_ASSET_STEP_BORROWER_IS_COMPLETED =
        'process_patch_set_initial_loan_asset_step_borrower_is_completed';
    public const PROCESS_PATCH_SET_NON_INITIAL_LOAN_ASSET_STEP_BORROWER_IS_COMPLETED =
        'process_patch_set_non_initial_loan_asset_step_borrower_is_completed';
    public const PROCESS_PATCH_SET_INITIAL_LOAN_ASSET_STEP_MERCHANT_IS_COMPLETED =
        'process_patch_set_initial_loan_asset_step_merchant_is_completed';
    public const PROCESS_PATCH_SET_NON_INITIAL_LOAN_ASSET_STEP_MERCHANT_IS_COMPLETED =
        'process_patch_set_non_initial_loan_asset_step_merchant_is_completed';
    public const PROCESS_PATCH_SET_LOAN_CALCULATOR = 'process_patch_set_loan_calculator';
    public const PROCESS_PATCH_CANCEL_LOAN = 'process_patch_cancel_loan';
    public const PROCESS_PATCH_CHANGE_LOAN_STATUS = 'process_patch_change_loan_status';

    private const ALLOWED_VALUES = [
        self::GET_LOAN_BY_ID,
        self::GET_LOAN_CALCULATOR,
        self::GET_LOANS_ACTION,
        self::GET_SELECTED_LOAN_APPLICATION_BY_ID,
        self::POST_LOAN,
        self::PROCESS_PATCH_CREATE_LOAN_ASSET_WITH_DECLARED_WORK_SITE_ADDRESS,
        self::PROCESS_PATCH_CREATE_LOAN_ASSET_WITH_FORMATTED_WORK_SITE_ADDRESS,
        self::PROCESS_PATCH_ADD_INITIAL_LOAN_ASSET_STEP,
        self::PROCESS_PATCH_ADD_NON_INITIAL_LOAN_ASSET_STEP,
        self::PROCESS_PATCH_SET_INITIAL_LOAN_ASSET_STEP_BORROWER_IS_COMPLETED,
        self::PROCESS_PATCH_SET_NON_INITIAL_LOAN_ASSET_STEP_BORROWER_IS_COMPLETED,
        self::PROCESS_PATCH_SET_INITIAL_LOAN_ASSET_STEP_MERCHANT_IS_COMPLETED,
        self::PROCESS_PATCH_SET_NON_INITIAL_LOAN_ASSET_STEP_MERCHANT_IS_COMPLETED,
        self::PROCESS_PATCH_SET_LOAN_CALCULATOR,
        self::PROCESS_PATCH_CANCEL_LOAN,
        self::PROCESS_PATCH_CHANGE_LOAN_STATUS
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_LOAN_BY_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_BORROWER)
            ],
            self::GET_LOAN_CALCULATOR => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_BORROWER)
            ],
            self::GET_LOANS_ACTION => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::GET_SELECTED_LOAN_APPLICATION_BY_ID => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT),
                new Role(Role::ROLE_FRONTEND_BORROWER),
            ],
            self::POST_LOAN => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::PROCESS_PATCH_CREATE_LOAN_ASSET_WITH_DECLARED_WORK_SITE_ADDRESS => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_CREATE_LOAN_ASSET_WITH_FORMATTED_WORK_SITE_ADDRESS => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_ADD_INITIAL_LOAN_ASSET_STEP => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::PROCESS_PATCH_ADD_NON_INITIAL_LOAN_ASSET_STEP => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::PROCESS_PATCH_SET_INITIAL_LOAN_ASSET_STEP_BORROWER_IS_COMPLETED => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_SET_NON_INITIAL_LOAN_ASSET_STEP_BORROWER_IS_COMPLETED => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_FRONTEND_LANDING),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_SET_INITIAL_LOAN_ASSET_STEP_MERCHANT_IS_COMPLETED => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::PROCESS_PATCH_SET_NON_INITIAL_LOAN_ASSET_STEP_MERCHANT_IS_COMPLETED => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::PROCESS_PATCH_SET_LOAN_CALCULATOR => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_CANCEL_LOAN => [
                new Role(Role::ROLE_SUPER_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::PROCESS_PATCH_CHANGE_LOAN_STATUS => [
                new Role(Role::ROLE_FRONTEND_ADMIN)
            ],
        ];
    }
}
