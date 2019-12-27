<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Rest\Resource;

use LogicException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Utils\StringService;

trait UrnTrait
{
    /**
     * @var string
     */
    protected $identifier;

    public function identifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param array $namespaces
     * @param string $aResourceId
     */
    protected function buildIdentifier(array $namespaces, string $aResourceId = ''): void
    {
        if (!is_array($namespaces)) {
            $this->throwLogicException();
        }

        $urn = array_merge(['urn', 'auditor_framework'], $namespaces);
        $urn[] = StringService::utf8Encode($aResourceId);
        $this->identifier = implode(':', $urn);
    }

    private function throwLogicException()
    {
        throw new LogicException(
            sprintf(
                'The list of provided namespaces for the resource class "%s" should be a valid array of strings',
                __CLASS__
            )
        );
    }

}
