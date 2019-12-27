<?php
/*
 * This file is part of the Nemuru package.
 *
 * (c) 2018 Antai Venture Builder SL <admin@antaivb.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\ReadModel;

use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\RoleWasAddedToUserEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserPasswordWasChangedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserWasBlockedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserWasCreatedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Event\UserWasUnblockedEvent;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Projection\MysqlUserReadModel;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

/**
 * @method readModel()
 */
class ProophUserProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('auditor_framework_event_stream')
            ->when([
                UserWasCreatedEvent::class => function ($state, UserWasCreatedEvent $event) {
                    /** @var MysqlUserReadModel $readModel */
                    $this->readModel()->stack(
                        'insert',
                        [
                            'id' => $event->aggregateId(),
                            'play_head' => $event->metadata()['_aggregate_version'],
                            'user_name_value' => $event->userName()->value(),
                            'roles' => json_encode($event->payload()['roles']),
                            'password' => $event->password(),
                            'active' => (int)$event->active(),
                            'user_type' => $event->userType()->userType(),
                            'created_at' => $event->createdAt()->format('Y-m-d H:i:s'),
                            'updated_at' => $event->updatedAt()->format('Y-m-d H:i:s')
                        ]
                    );
                    return $state;
                },
                RoleWasAddedToUserEvent::class => function ($state, RoleWasAddedToUserEvent $event) {
                    /** @var MysqlUserReadModel $readModel */
                    $this->readModel()->stack(
                        'update',
                        [
                            'play_head' => $event->metadata()['_aggregate_version'],
                            'roles' => json_encode($event->payload()['user']['roles']),
                            'updated_at' => $event->updatedAt()->format('Y-m-d H:i:s')
                        ],
                        [
                            'id' => $event->aggregateId()
                        ]
                    );
                    return $state;
                },
                UserPasswordWasChangedEvent::class => function ($state, UserPasswordWasChangedEvent $event) {
                    /** @var MysqlUserReadModel $readModel */
                    $this->readModel()->stack(
                        'update',
                        [
                            'play_head' => $event->metadata()['_aggregate_version'],
                            'password' => $event->newPassword(),
                            'updated_at' => $event->updatedAt()->format('Y-m-d H:i:s')
                        ],
                        [
                            'id' => $event->aggregateId()
                        ]
                    );
                    return $state;
                },
                UserWasBlockedEvent::class => function ($state, UserWasBlockedEvent $event) {
                    /** @var MysqlUserReadModel $readModel */
                    $this->readModel()->stack(
                        'update',
                        [
                            'play_head' => $event->metadata()['_aggregate_version'],
                            'is_blocked' => (int) $event->blockControl()->isBlocked(),
                            'block_date' => $event->blockControl()->blockDate(),
                            'updated_at' => $event->updatedAt()->format('Y-m-d H:i:s')
                        ],
                        [
                            'id' => $event->aggregateId()
                        ]
                    );
                    return $state;
                },
                UserWasUnblockedEvent::class => function ($state, UserWasUnblockedEvent $event) {
                    /** @var MysqlUserReadModel $readModel */
                    $this->readModel()->stack(
                        'update',
                        [
                            'play_head' => $event->metadata()['_aggregate_version'],
                            'is_blocked' => (int) $event->blockControl()->isBlocked(),
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
