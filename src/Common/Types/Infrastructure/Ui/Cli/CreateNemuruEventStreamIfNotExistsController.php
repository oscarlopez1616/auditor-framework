<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Cli;

use ArrayIterator;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateNemuruEventStreamIfNotExistsController extends Command
{
    /**
     * @var EventStore
     */
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        parent::__construct();
        $this->eventStore = $eventStore;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $streamName = new StreamName('auditor_framework_event_stream');

        if (!$this->eventStore->hasStream($streamName)) {
             $this->eventStore->create(
                 new Stream(
                     $streamName,
                     new ArrayIterator()
                 )
             );
        }
    }

    protected function configure()
    {
        $this
            ->setName('auditor_framework:event-stream:create')
            ->setDescription('Create the auditor_framework event stream database table');
    }
}
