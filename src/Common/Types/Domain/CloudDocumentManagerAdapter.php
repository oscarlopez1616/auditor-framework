<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

abstract class CloudDocumentManagerAdapter
{
    public abstract function saveCloudDocument(CloudDocument $cloudDocument, string $data): void;

    public abstract function cloudDocumentDataAsRawString(CloudDocument $cloudDocument): string;

    public abstract function cloudDocumentDateTime(CloudDocument $cloudDocument): \DateTime;

    public abstract function deleteCloudDocumentIfExist(CloudDocument $cloudDocument): void;

}
