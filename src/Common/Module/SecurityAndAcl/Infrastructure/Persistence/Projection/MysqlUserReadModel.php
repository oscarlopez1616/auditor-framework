<?php

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Infrastructure\Persistence\Projection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\ReadModel\UserReadModel;
use Prooph\EventStore\Projection\AbstractReadModel;

class MysqlUserReadModel extends AbstractReadModel implements UserReadModel
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
            create table security_and_acl_user
            (
                id              char(36)     not null comment '(DC2Type:guid)'
                    primary key,
                play_head       int          not null,
                created_at      datetime     not null comment '(DC2Type:datetime_immutable)',
                updated_at      datetime     not null,
                roles           json         not null comment '(DC2Type:json)',
                password        varchar(255) not null,
                active          tinyint(1)   not null,
                user_name_value varchar(64)  not null,
                user_type       varchar(255) not null,
                constraint UNIQ_4A4FE7317436CC9D
                    unique (user_name_value)
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
            ->executeQuery("SHOW TABLES like 'security_and_acl_user'")
            ->rowCount();
    }

    /**
     * @throws DBALException
     */
    public function reset(): void
    {
        $this->connection->executeQuery("TRUNCATE TABLE `security_and_acl_user`;");
    }

    /**
     * @throws DBALException
     */
    public function delete(): void
    {
        $this->connection->executeQuery("DROP TABLE `auditor_framework`.security_and_acl_user;");
    }

    /**
     * @param array $data
     *
     * @throws DBALException
     */
    public function insert(array $data)
    {
        $this->connection->insert("security_and_acl_user", $data);
    }

    /**
     * @param array $data
     * @param array $id
     *\
     * @throws DBALException
     */
    public function update(array $data, array $id)
    {
        $this->connection->update("security_and_acl_user", $data, $id);
    }
}
