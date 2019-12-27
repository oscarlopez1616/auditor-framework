<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\UploadCsvKeyValue;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;

class UploadCsvKeyValueCommand implements Command
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $data;

    /**
     * UploadCsvKeyValueCommand constructor.
     * @param string $id
     * @param string $data
     */
    public function __construct(string $id, string $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function data(): string
    {
        return $this->data;
    }
}
