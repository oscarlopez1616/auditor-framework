<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

abstract class RestResource
{
    /**
     * @var string
     */
    protected $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

}
