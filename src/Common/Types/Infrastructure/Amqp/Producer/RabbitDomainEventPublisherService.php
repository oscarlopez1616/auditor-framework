<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Amqp\Producer;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\AmqpCommandPublisherService;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Event\Event;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitDomainEventPublisherService implements AmqpCommandPublisherService
{
    /**
     * @var Producer
     */
    private $producer;


    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    public function publish(Event $event): void
    {
        $this->producer->publish(
            json_encode(
                [
                    'id' => $event->id()->value(),
                    'payload' => $event->payload(),
                    'metadata' => $event->metadata(),
                    'created_at' => $event->createdAt()->format('Y-m-d H:i:s'),
                    'event_class' => get_class($event)
                ]
            )
        );
    }

    public function publishAMQPMessage(AMQPMessage $msg): void
    {
        $this->producer->publish(
            $msg->body
        );
    }
}
