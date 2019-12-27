<?php

declare(strict_types=1);

namespace AuditorFramework\Common\Types\Application\QueryBus;

use React\Promise\Deferred;

interface QueryHandler
{
    /**
     * @param Query $query
     * @param Deferred $deferred
     * @return mixed
     */
    public function __invoke(Query $query, Deferred $deferred);
}
