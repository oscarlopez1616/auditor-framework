<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Role;

class BorrowerBankReaderControllerVoter extends ControllerVoter
{
    public const GET_BORROWER_BANK_READER_BY_ID = 'get_borrower_bank_reader_by_id';
    public const POST_BORROWER_BANK_READER = 'post_borrower_bank_reader';
    public const PROCESS_PATCH_ADD_CREDENTIALS_TOKEN_TO_BORROWER_BANK_READER_COMMAND = 'process_patch_add_credentials_token_to_borrower_bank_reader_command';
    public const PROCESS_PATCH_ADD_ACCOUNTS_TO_BORROWER_BANK_READER_COMMAND = 'process_patch_add_accounts_to_borrower_bank_reader_command';

    private const ALLOWED_VALUES = [
        self::GET_BORROWER_BANK_READER_BY_ID,
        self::POST_BORROWER_BANK_READER,
        self::PROCESS_PATCH_ADD_CREDENTIALS_TOKEN_TO_BORROWER_BANK_READER_COMMAND,
        self::PROCESS_PATCH_ADD_ACCOUNTS_TO_BORROWER_BANK_READER_COMMAND
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::GET_BORROWER_BANK_READER_BY_ID => [
                new Role(Role::ROLE_RISK),
                new Role(Role::ROLE_FRONTEND_BORROWER)
            ],
            self::POST_BORROWER_BANK_READER => [],
            self::PROCESS_PATCH_ADD_CREDENTIALS_TOKEN_TO_BORROWER_BANK_READER_COMMAND => [],
            self::PROCESS_PATCH_ADD_ACCOUNTS_TO_BORROWER_BANK_READER_COMMAND => [],
        ];
    }
}
