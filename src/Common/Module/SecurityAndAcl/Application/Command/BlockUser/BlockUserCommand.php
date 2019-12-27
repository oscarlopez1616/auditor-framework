<?php


namespace AuditorFramework\Common\Module\SecurityAndAcl\Application\Command\BlockUser;


use AuditorFramework\Common\Types\Application\CommandBus\Command;

class BlockUserCommand implements Command
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
