<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Csv\DataTransformer;

use AuditorFramework\Common\Types\Domain\CloudDocument;
use AuditorFramework\Common\Types\Domain\CloudDocumentType;
use AuditorFramework\Common\Types\Infrastructure\Csv\CsvKeyValueName;
use AuditorFramework\Common\Types\Infrastructure\Csv\CsvReader;

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
