<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class BorrowerControllerVoter extends ControllerVoter
{
    public const GET_BORROWER_BY_PHONE_NUMBER = 'get_borrower_by_phone_number';
    public const GET_BORROWER_BY_PHONE_NUMBER_AND_BY_EMAIL = 'get_borrower_by_phone_number_and_by_email';
    public const GET_BORROWER_BY_EMAIL = 'get_borrower_by_email';
    public const GET_BORROWER_DOCUMENT_ID_FRONT_BY_EMAIL = 'get_borrower_document_id_front_by_email';
    public const GET_BORROWER_DOCUMENT_ID_BACK_BY_EMAIL = 'get_borrower_document_id_back_by_email';
    public const POST_BORROWER = 'post_borrower';

    public const PROCESS_PATCH_SET_BORROWER_ID_TO_LOAN =
        'process_patch_set_borrower_id_to_loan';

    public const PATCH_ADD_BORROWER_CASH_IN_CASH_OUT_METHOD = 'patch_add_borrower_cash_in_cash_out_method';

    public const PROCESS_PATCH_SET_USER_DETAILS_WITH_FORMATTED_DOCUMENT_ID_ADDRESS_AND_FORMATTED_RESIDENCE_ADDRESS =
        'process_patch_set_user_details_with_formatted_document_id_address_and_formatted_residence_address';
    public const PROCESS_PATCH_SET_USER_DETAILS_WITH_FORMATTED_DOCUMENT_ID_ADDRESS_AND_DECLARED_RESIDENCE_ADDRESS =
        'process_patch_set_user_details_with_formatted_document_id_address_and_declared_residence_address';
    public const PROCESS_PATCH_SET_USER_DETAILS_WITH_DECLARED_DOCUMENT_ID_ADDRESS_AND_DECLARED_RESIDENCE_ADDRESS =
        'process_patch_set_user_details_with_declared_document_id_address_and_declared_residence_address';
    public const PROCESS_PATCH_SET_PROFESSIONAL_DETAILS =
        'process_patch_set_professional_details';

    private const ALLOWED_VALUES = [
        self::GET_BORROWER_BY_PHONE_NUMBER,
        self::GET_BORROWER_BY_PHONE_NUMBER_AND_BY_EMAIL,
        self::GET_BORROWER_BY_EMAIL,
        self::POST_BORROWER,
        self::PROCESS_PATCH_SET_BORROWER_ID_TO_LOAN,
        self::PROCESS_PATCH_SET_USER_DETAILS_WITH_FORMATTED_DOCUMENT_ID_ADDRESS_AND_FORMATTED_RESIDENCE_ADDRESS,
        self::PROCESS_PATCH_SET_USER_DETAILS_WITH_FORMATTED_DOCUMENT_ID_ADDRESS_AND_DECLARED_RESIDENCE_ADDRESS,
        self::PROCESS_PATCH_SET_USER_DETAILS_WITH_DECLARED_DOCUMENT_ID_ADDRESS_AND_DECLARED_RESIDENCE_ADDRESS,
        self::PROCESS_PATCH_SET_PROFESSIONAL_DETAILS,
        self::PATCH_ADD_BORROWER_CASH_IN_CASH_OUT_METHOD,
        self::GET_BORROWER_DOCUMENT_ID_FRONT_BY_EMAIL,
        self::GET_BORROWER_DOCUMENT_ID_BACK_BY_EMAIL
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_BORROWER_BY_PHONE_NUMBER => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::GET_BORROWER_BY_PHONE_NUMBER_AND_BY_EMAIL => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER),
                new Role(Role::ROLE_MERCHANT)
            ],
            self::GET_BORROWER_BY_EMAIL => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_COMMERCIAL),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::POST_BORROWER => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_SET_BORROWER_ID_TO_LOAN => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_SET_USER_DETAILS_WITH_FORMATTED_DOCUMENT_ID_ADDRESS_AND_FORMATTED_RESIDENCE_ADDRESS => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_SET_USER_DETAILS_WITH_FORMATTED_DOCUMENT_ID_ADDRESS_AND_DECLARED_RESIDENCE_ADDRESS => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_SET_USER_DETAILS_WITH_DECLARED_DOCUMENT_ID_ADDRESS_AND_DECLARED_RESIDENCE_ADDRESS => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PROCESS_PATCH_SET_PROFESSIONAL_DETAILS => [
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_BORROWER)
            ],
            self::PATCH_ADD_BORROWER_CASH_IN_CASH_OUT_METHOD => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_BORROWER),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN)
            ],
            self::GET_BORROWER_DOCUMENT_ID_FRONT_BY_EMAIL => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN)
            ],
            self::GET_BORROWER_DOCUMENT_ID_BACK_BY_EMAIL => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_ADMIN),
                new Role(Role::ROLE_ADMIN),
                new Role(Role::ROLE_SUPER_ADMIN)
            ],
        ];
    }
}
