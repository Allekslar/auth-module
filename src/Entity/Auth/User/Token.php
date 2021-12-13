<?php

declare(strict_types=1);

namespace App\Entity\Auth\User;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
final class Token
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $value;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $validity;

    public function __construct(string $value, DateTimeImmutable $validity)
    {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
        $this->validity = $validity;
    }

    public function validate(string $value, DateTimeImmutable $date): void
    {
        if (!$this->isEqualTo($value)) {
            throw new DomainException('Token is invalid.');
        }
        if ($this->isExpiredTo($date)) {
            throw new DomainException('Token is expired.');
        }
    }

    public function isExpiredTo(DateTimeImmutable $date): bool
    {
        return $this->validity < $date;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getValidity(): DateTimeImmutable
    {
        return $this->validity;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    private function isEqualTo(string $value): bool
    {
        return $this->value === $value;
    }
}