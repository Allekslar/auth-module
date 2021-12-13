<?php

declare(strict_types=1);

namespace App\Entity\Auth\User;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final class Id
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
    }

    public static function generate(): self
    {
        return new self(Uuid::v6()->toRfc4122());
    }

    public function getValue(): string
    {
        return $this->value;
    }
    
    public function __toString(): string
    {
        return $this->getValue();
    }

}