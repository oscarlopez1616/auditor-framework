<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\NotInAllowedValuesException;

class CloudDocumentType extends ValueObject
{
    public const DOCUMENT_ID_FRONT = 'document_id_front';
    public const DOCUMENT_ID_BACK = 'document_id_back';
    public const ACCOUNT_HOLDER_ACCOUNT_AND_INCOME_CERTIFICATION_DOCUMENT = 'account_holder_account_and_income_certification_document';
    public const LOAN_LENDER_BORROWER_CONTRACT = 'loan_lender_borrower_contract';
    public const BORROWER_BANK_READER = 'borrower_bank_reader';
    public const BORROWER_AML = 'borrower_aml';
    public const BORROWER_ASNEF = 'borrower_asnef';
    public const CSV_KEY_VALUE = 'csv_key_value';
    public const NET_INCOME = 'net_income';


    private const ALLOWED_VALUES = [
        self::DOCUMENT_ID_FRONT,
        self::DOCUMENT_ID_BACK,
        self::ACCOUNT_HOLDER_ACCOUNT_AND_INCOME_CERTIFICATION_DOCUMENT,
        self::LOAN_LENDER_BORROWER_CONTRACT,
        self::BORROWER_BANK_READER,
        self::BORROWER_AML,
        self::BORROWER_ASNEF,
        self::CSV_KEY_VALUE,
        self::NET_INCOME
    ];

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;

    }

    private function guard(string $value): void
    {
        $this->guardValue($value);
    }

    private function guardValue(string $value): void
    {
        if (!in_array($value, self::ALLOWED_VALUES)) {
            throw new NotInAllowedValuesException($value, self::ALLOWED_VALUES);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param ValueObject|self $o
     *
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->value === $o->value();
    }
}
