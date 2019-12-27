<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Csv\DataTransformer;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocument;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocumentType;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Csv\CsvKeyValueName;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Csv\CsvReader;

class KeyValueFromCsvDataTransformer
{
    /**
     * @var CsvReader
     */
    private $csvReader;

    /**
     * KeyValueFromCsvDataTransformer constructor.
     * @param CsvReader $csvReader
     */
    public function __construct(CsvReader $csvReader)
    {
        $this->csvReader = $csvReader;
    }

    public function transform(string $key,CsvKeyValueName $csvKeyValueName): string
    {
        $value = $this->csvReader->findOrFailValueByKey(
            $key,
            new CloudDocument(
                $csvKeyValueName->id(),
                'csv',
                new CloudDocumentType(CloudDocumentType::CSV_KEY_VALUE)
            )
        );
        return $value;
    }

}
