<?php


namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\UnblockUser;


use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Application\CommandBus\Command;

class UnblockUserCommand implements Command
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
