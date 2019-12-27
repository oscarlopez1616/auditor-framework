<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\FileSystem;

use DateTime;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocument;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\CloudDocumentManagerAdapter;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\FileExistDomainException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\FileNotFoundDomainException;


class TheLeagueCloudDocumentManager extends CloudDocumentManagerAdapter
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function saveCloudDocument(CloudDocument $cloudDocument, string $data): void
    {
        if ($this->filesystem->has($cloudDocument->linkResource())) {
            $this->deleteCloudDocumentIfExist($cloudDocument);
        }
        try {
            $this->filesystem->write(
                $cloudDocument->linkResource(), $data, [
                    'Metadata' => [
                        'cloud_document_type' => $cloudDocument->cloudDocumentType()->value(),
                    ]
                ]
            );
        } catch (FileExistsException $e){
            throw new FileExistDomainException($e->getMessage());
        }
    }

    public function deleteCloudDocumentIfExist(CloudDocument $cloudDocument): void
    {
        try {
            $this->filesystem->delete($cloudDocument->linkResource());
        }catch (FileNotFoundException $e){
        }
    }

    public function cloudDocumentDataAsRawString(CloudDocument $cloudDocument): string
    {
        try {
            return $this->filesystem->read($cloudDocument->linkResource());
        }catch (FileNotFoundException $e){
            throw new FileNotFoundDomainException($e->getMessage());
        }
    }

    public function cloudDocumentDateTime(CloudDocument $cloudDocument): DateTime
    {
        try {
            $time = $this->filesystem->getTimestamp($cloudDocument->linkResource());
        } catch (FileNotFoundException $e){
            throw new FileNotFoundDomainException($e->getMessage());
        }

        if (!$time) {
            throw new FileNotFoundDomainException("Document not found: {$cloudDocument->linkResource()}");
        }

        $dt = new DateTime();
        $dt->setTimestamp($time);

        return $dt;
    }
}
