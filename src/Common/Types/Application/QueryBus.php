<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application;

use Exception;
use Prooph\ServiceBus\QueryBus as ProophQueryBus;

class QueryBus
{
    /**
     * @var ProophQueryBus
     */
    private $queryBus;

    /**
     * CommandBus constructor.
     * @param ProophQueryBus $queryBus
     */
    public function __construct(ProophQueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }


    /**
     * @param $query
     * @return string
     * @throws Exception
     */
    public function dispatch($query)
    {
        $result = "";
        /**
         * @var Exception $exception
         */
        $exception = null;

       $this->queryBus->dispatch($query)->then(
            function ($_result) use (&$result) {
                $result = $_result;
            },
            function ($_exception) use (&$exception) {
                $exception = $_exception;
            }
       );

       if($exception !== null){
           throw $exception->getPrevious();
       }

       return $result;
    }

}
