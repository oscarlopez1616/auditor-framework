<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\Api;

class CsvControllerVoter extends ControllerVoter
{
    public const POST_CSV_KEY_VALUE = 'post_csv_key_value';

    private const ALLOWED_VALUES = [
        self::POST_CSV_KEY_VALUE
    ];

    protected function allowedValues(): array
    {
        return self::ALLOWED_VALUES;
    }

    protected function getAllowedRolesByAttributeMap(): array
    {
        return [
            self::POST_CSV_KEY_VALUE => [
            ]
        ];
    }
}
