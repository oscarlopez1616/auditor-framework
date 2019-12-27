<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Persistence\Projection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Prooph\EventStore\Projection\AbstractReadModel;

abstract class MysqlSingleTableReadModel extends AbstractReadModel
{
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    abstract protected function getTableName(): string;

    /**
     * @return bool
     *
     * @throws DBALException
     */
    public function isInitialized(): bool
    {
        return $this
            ->connection
            ->executeQuery("SHOW TABLES like '{$this->getTableName()}'")
            ->rowCount();
    }

    /**
     * @throws DBALException
     */
    public function reset(): void
    {
        $this->connection->executeQuery("TRUNCATE TABLE {$this->getTableName()};");
    }

    /**
     * @throws DBALException
     */
    public function delete(): void
    {
        $this->connection->executeQuery("DROP TABLE {$this->getTableName()};");
    }

    /**
     * @param array $data
     *
     * @throws DBALException
     */
    public function insert(array $data)
    {
        $this->connection->insert($this->getTableName(), $data);
    }

    /**
     * @param array $data
     * @param array $id
     *\
     * @throws DBALException
     */
    public function update(array $data, array $id)
    {
        $this->connection->update($this->getTableName(), $data, $id);
    }
}
