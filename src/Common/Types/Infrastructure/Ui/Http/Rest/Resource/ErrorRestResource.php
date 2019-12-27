<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

final class ErrorRestResource extends RestResource
{
    use UrnTrait;

    /**
     * @var string
     */
    private $error;

    /**
     * @var string
     */
    private $exception;

    public function __construct(array $namespaces, string $error, string $exception)
    {
        parent::__construct('ko');
        $this->error = $error;
        $this->exception = $exception;
        $this->buildIdentifier($namespaces);
    }
}
