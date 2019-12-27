<?php
/** @noinspection PhpUndefinedClassInspection */
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\UploadCsvKeyValue;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\ApplicationService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocument;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocumentManagerAdapter;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocumentType;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Uuid;

class UploadCsvKeyValueService implements ApplicationService
{
    /**
     * @var CloudDocumentManagerAdapter
     */
    private $cloudDocumentManagerAdapter;

    public function __construct(CloudDocumentManagerAdapter $cloudDocumentManagerAdapter)
    {
        $this->cloudDocumentManagerAdapter = $cloudDocumentManagerAdapter;
    }

    public function execute(Uuid $uuid, string $data): void
    {
        $this->cloudDocumentManagerAdapter->saveCloudDocument(
            new CloudDocument(
                $uuid,
                'csv',
                new CloudDocumentType(CloudDocumentType::CSV_KEY_VALUE)
            ),
            $data
        );
    }
}
