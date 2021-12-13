<?php

declare(strict_types=1);

namespace App\Unit\User;

use App\Entity\Auth\User\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Auth\User\Email
 *
 * @internal
 */
final class EmailTest extends TestCase
{
    public function testEmailSuccess(): void
    {
        $email = new Email($value = 'test@test.test');

        self::assertEquals($value, $email->getValue());
    }

    public function testEmailCase(): void
    {
        $email = new Email('TesT@test.test');

        self::assertEquals('test@test.test', $email->getValue());
    }

    public function testEmailIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('incorrect-email');
    }

    public function testEmailEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }
}
