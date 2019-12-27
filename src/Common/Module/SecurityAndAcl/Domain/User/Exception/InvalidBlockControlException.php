<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception;

use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\Exception\DomainException;

class InvalidBlockControlException extends DomainException
{
    /**
     * @var string
     */
    private $messageError;

    public function __construct(bool $isBlocked, string $blockDate)
    {
        $this->messageError = sprintf(
            '%s %s, %s',
            "An Error has occurred When BlockControl has been created with values: ",
            ($isBlocked) ? 'true' : 'false',
            $blockDate
        );
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return $this->messageError;
    }

}
