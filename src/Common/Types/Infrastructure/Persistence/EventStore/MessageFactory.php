<?php
declare(strict_types=1);

namespace AuditorFramework\Common\Types\Infrastructure\Persistence\EventStore;

use AuditorFramework\Common\Types\Domain\Event\Event;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\Common\Messaging\Message;

class MessageFactory extends FQCNMessageFactory
{
    public function createMessageFromArray(string $messageName, array $messageData): Message
    {
        $message = parent::createMessageFromArray($messageName, $messageData);

        if ($message instanceof Event) {
            $message->unserialize();
        }

        return $message;
    }
}
