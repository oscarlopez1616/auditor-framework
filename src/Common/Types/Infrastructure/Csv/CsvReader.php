<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Csv;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocument;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocumentManagerAdapter;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Exception\CsvKeyNotFoundException;

class CsvReader
{
    /**
     * @var CloudDocumentManagerAdapter
     */
    private $cloudDocumentManagerAdapter;

    /**
     * CsvReader constructor.
     * @param CloudDocumentManagerAdapter $cloudDocumentManagerAdapter
     */
    public function __construct(CloudDocumentManagerAdapter $cloudDocumentManagerAdapter)
    {
        $this->cloudDocumentManagerAdapter = $cloudDocumentManagerAdapter;
    }


    public function findOrFailValueByKey(string $key,CloudDocument $csvCloudDocument): string
    {
        $csvAsString= $this->cloudDocumentManagerAdapter->cloudDocumentDataAsRawString($csvCloudDocument);
        $lines = explode(PHP_EOL, $csvAsString);

        $csvAsArr = array();
        foreach ($lines as $line) {
            $temp = str_getcsv($line,',\n','""');
            $csvAsArr['key'][] = $temp[0];
            $csvAsArr['value'][] = $temp[1];
        }

        $i=0;
        foreach ($csvAsArr['key'] as $currentKey){
            if($currentKey === $key){
                return $csvAsArr['value'][$i];
            }
            $i++;
        }

        throw new CsvKeyNotFoundException($key);
    }
}
