<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Domain;

use Exception;
use AuditorFramework\Common\Utils\Assertion\DomainAssertion;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends Id
{

    public function __construct(string $value)
    {
        $this->guard($value);
        parent::__construct($value);
    }

    /**
     * @return Uuid
     * @throws Exception
     */
    public static function create(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }


    private function guard(string $value): void
    {
        DomainAssertion::isUuid($value);
    }
}
