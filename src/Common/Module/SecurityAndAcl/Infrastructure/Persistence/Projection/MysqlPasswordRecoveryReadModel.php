<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Projection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\ReadModel\PasswordRecoveryReadModel;
use Prooph\EventStore\Projection\AbstractReadModel;

class MysqlPasswordRecoveryReadModel extends AbstractReadModel implements PasswordRecoveryReadModel
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DBALException
     */
    public function init(): void
    {
        $this->connection->executeQuery(<<<SQL
            create table security_and_acl_password_recovery
            (
                id              char(36)   not null comment '(DC2Type:guid)'
                    primary key,
                play_head       int        not null,
                created_at      datetime   not null comment '(DC2Type:datetime_immutable)',
                updated_at      datetime   not null,
                user_id         char(36)   not null comment '(DC2Type:guid)',
                has_been_used   tinyint(1) not null,
                expiration_date datetime   not null
            )
                collate = utf8mb4_unicode_ci ENGINE = InnoDB;
            SQL
        );
    }

    /**
     * @return bool
     *
     * @throws DBALException
     */
    public function isInitialized(): bool
    {
        return $this
            ->connection
            ->executeQuery("SHOW TABLES like 'security_and_acl_password_recovery'")
            ->rowCount();
    }

    /**
     * @throws DBALException
     */
    public function reset(): void
    {
        $this->connection->executeQuery("TRUNCATE TABLE `security_and_acl_password_recovery`;");
    }

    /**
     * @throws DBALException
     */
    public function delete(): void
    {
        $this->connection->executeQuery("DROP TABLE `auditor_framework`.security_and_acl_password_recovery;");
    }

    /**
     * @param array $data
     *
     * @throws DBALException
     */
    public function insert(array $data)
    {
        $this->connection->insert("security_and_acl_password_recovery", $data);
    }

    /**
     * @param array $data
     * @param array $id
     *\
     * @throws DBALException
     */
    public function update(array $data, array $id)
    {
        $this->connection->update("security_and_acl_password_recovery", $data, $id);
    }
}
