<?php
/*
 * This file is part of the Nemuru package.
 *
 * (c) 2018 Antai Venture Builder SL <admin@antaivb.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\ReadModel;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Event\PasswordRecoveryWasCreatedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\Event\PasswordRecoveryWasUsedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Projection\MysqlPasswordRecoveryReadModel;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

/**
 * @method readModel()
 */
class ProophPasswordRecoveryProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('auditor_framework_event_stream')
            ->when([
                PasswordRecoveryWasCreatedEvent::class => function ($state, PasswordRecoveryWasCreatedEvent $event) {
                    /** @var MysqlPasswordRecoveryReadModel $readModel */
                    $this->readModel()->stack(
                        'insert',
                        [
                            'id' => $event->aggregateId(),
                            'play_head' => $event->metadata()['_aggregate_version'],
                            'user_id' => $event->userId()->value(),
                            'has_been_used' => (int)$event->hasBeenUsed(),
                            'expiration_date' => $event->expirationDate()->format('Y-m-d H:i:s'),
                            'created_at' => $event->createdAt()->format('Y-m-d H:i:s'),
                            'updated_at' => $event->updatedAt()->format('Y-m-d H:i:s')
                        ]
                    );
                    return $state;
                },
                PasswordRecoveryWasUsedEvent::class => function ($state, PasswordRecoveryWasUsedEvent $event) {
                    /** @var MysqlPasswordRecoveryReadModel $readModel */
                    $this->readModel()->stack(
                        'update',
                        [
                            'play_head' => $event->metadata()['_aggregate_version'],
                            'has_been_used' => (int)$event->hasBeenUsed(),
                            'updated_at' => $event->updatedAt()->format('Y-m-d H:i:s')
                        ],
                        [
                            'id' => $event->aggregateId()
                        ]
                    );
                    return $state;
                }
            ]);
        return $projector;
    }
}
