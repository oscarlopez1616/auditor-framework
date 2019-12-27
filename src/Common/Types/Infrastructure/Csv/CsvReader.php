<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Csv;

use AuditorFramework\Common\Types\Domain\CloudDocument;
use AuditorFramework\Common\Types\Domain\CloudDocumentManagerAdapter;
use AuditorFramework\Common\Types\Infrastructure\Exception\CsvKeyNotFoundException;

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
