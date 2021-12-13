<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Entity\Auth\User\Token;
use DateInterval;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class Tokenizer
{
    private DateInterval $interval;

    public function __construct(DateInterval $interval)
    {
        $this->interval = $interval;
    }

    public function generate(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::v6()->toRfc4122(),
            $date->add($this->interval)

        );
    }
}