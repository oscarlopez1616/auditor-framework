<?php
/** @noinspection PhpUndefinedClassInspection */
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Application\UploadCsvKeyValue;

use AuditorFramework\Common\Types\Application\ApplicationService;
use AuditorFramework\Common\Types\Domain\CloudDocument;
use AuditorFramework\Common\Types\Domain\CloudDocumentManagerAdapter;
use AuditorFramework\Common\Types\Domain\CloudDocumentType;
use AuditorFramework\Common\Types\Domain\Uuid;

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
