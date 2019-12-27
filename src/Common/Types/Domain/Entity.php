<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\AggregateRootAlreadyRegisteredInEntityException;
use Prooph\EventSourcing\AggregateChanged;
use function Lambdish\Phunctional\map;

abstract class Entity extends BaseEntity
{
    /**
     * @var AggregateRoot
     */
    private $aggregateRoot;

    protected function apply(AggregateChanged $event): void
    {
        $this->aggregateRoot->apply($event);
    }

    public function handleRecursively(AggregateChanged $event): void
    {
        $this->handle($event);
        map(
            function (Entity $entity) use ($event) {
                $entity->registerAggregateRoot($this->aggregateRoot);
                $entity->handleRecursively($event);
            },
            $this->getChildEntities()
        );
    }

    protected function handle(AggregateChanged $event)
    {
        $functionName = 'apply' . $this->getClassNameWithoutNamespace(get_class($event));
        if (method_exists($this, $functionName)) {
            call_user_func([$this, $functionName], $event);
        }
    }


    /**
     * Add all entities contain in the Aggregate as an array. If your aggregate doesn't contain child entities, just
     * return [].
     *
     * @return Entity[]
     */
    abstract protected function getChildEntities(): array;

    private function getClassNameWithoutNamespace(string $className): string
    {
        $path = explode('\\', $className);

        return array_pop($path);
    }

    public function registerAggregateRoot(?AggregateRoot $aggregateRoot): void
    {
        if (null !== $this->aggregateRoot && $this->aggregateRoot !== $aggregateRoot) {
            throw new AggregateRootAlreadyRegisteredInEntityException(get_class($aggregateRoot), get_class($this));
        }
        $this->aggregateRoot = $aggregateRoot;
    }

}
