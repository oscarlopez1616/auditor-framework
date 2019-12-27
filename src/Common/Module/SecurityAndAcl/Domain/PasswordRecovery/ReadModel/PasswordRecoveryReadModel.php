<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\PasswordRecovery\ReadModel;

interface PasswordRecoveryReadModel
{
    public function init(): void;
    public function isInitialized(): bool;
    public function reset(): void;
    public function delete(): void;
    public function insert(array $data);
    public function update(array $data, array $id);
}
