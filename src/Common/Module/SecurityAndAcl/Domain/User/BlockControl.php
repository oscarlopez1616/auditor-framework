<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User;

use DateTime;
use TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain\ValueObject;
use TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion\DomainAssertion;
use TheCodeFighters\Bundle\AuditorFramework\Common\Module\SecurityAndAcl\Domain\User\Exception\InvalidBlockControlException;

class BlockControl extends ValueObject
{

    /**
     * @var bool
     */
    private $isBlocked;

    /**
     * @var DateTime|null
     */
    private $blockDate;

    public function __construct(bool $isBlocked, ?string $blockDate)
    {
        $this->guard($isBlocked, $blockDate);
        $this->isBlocked = $isBlocked;
        $this->blockDate = is_null($blockDate) ? null : DateTime::createFromFormat(DATE_ATOM, $blockDate);
    }

    private function guard(bool $isBlocked, ?string $blockDate): void
    {
        if (($isBlocked && is_null($blockDate)) || (!$isBlocked && !is_null($blockDate))) {
            throw new InvalidBlockControlException($isBlocked, $blockDate);
        }
        if ($isBlocked && !is_null($blockDate)) {
            $this->guardValue($blockDate);
        }
    }

    private function guardValue(string $blockDate) {
        DomainAssertion::isValidDate($blockDate, DATE_ATOM);
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function blockDate(): ?DateTime
    {
        return $this->blockDate;
    }

    /**
     * @param ValueObject|self $o
     *
     * @return bool
     */
    protected function equalValues(ValueObject $o): bool
    {
        return $this->isBlocked === $o->isBlocked()
            && $this->blockDate === $o->blockDate();
    }
}
