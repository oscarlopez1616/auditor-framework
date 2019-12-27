<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use PhpAmqpLib\Message\AMQPMessage;

interface AmqpCommandPublisherService
{
    public function publish(Event $event): void;

    public function publishAMQPMessage(AMQPMessage $msg): void;
}
