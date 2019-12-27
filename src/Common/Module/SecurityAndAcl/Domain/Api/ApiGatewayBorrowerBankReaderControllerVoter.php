<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class ApiGatewayBorrowerBankReaderControllerVoter extends ControllerVoter
{
    public const GET_BORROWER_BANK_READER_WIDGET = 'get_borrower_bank_reader_widget';
    public const POST_DOCUMENT_ID_IMAGES_ACTION = 'post_document_id_images_action';
    public const PROCESS_PATCH_SET_USER_DETAILS_WITH_DOCUMENT_ID_IMAGES_REQUEST_ID =
        'process_patch_set_user_details_with_document_id_images_request_id';
    public const PROCESS_PATCH_SET_USER_DETAILS_WITH_DOCUMENT_ID_DECLARED_ADDRESS =
        'process_patch_set_user_details_with_document_id_declared_address';

    private const ALLOWED_VALUES = [
        self::GET_BORROWER_BANK_READER_WIDGET,
        self::POST_DOCUMENT_ID_IMAGES_ACTION,
        self::PROCESS_PATCH_SET_USER_DETAILS_WITH_DOCUMENT_ID_IMAGES_REQUEST_ID,
        self::PROCESS_PATCH_SET_USER_DETAILS_WITH_DOCUMENT_ID_DECLARED_ADDRESS
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_BORROWER_BANK_READER_WIDGET =>[
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::POST_DOCUMENT_ID_IMAGES_ACTION => [
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::PROCESS_PATCH_SET_USER_DETAILS_WITH_DOCUMENT_ID_IMAGES_REQUEST_ID => [
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::PROCESS_PATCH_SET_USER_DETAILS_WITH_DOCUMENT_ID_DECLARED_ADDRESS => [
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ]
        ];
    }
}
