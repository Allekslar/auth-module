<?php

declare(strict_types=1);

namespace App\Unit\Service;

use App\Service\Auth\PasswordHasher;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Service\Auth\PasswordHasher
 *
 * @internal
 */
final class PasswordHasherTest extends TestCase
{

    public function testHashEmpty(): void
    {
        $hasher = new PasswordHasher(32);
        $this->expectException(InvalidArgumentException::class);
        $hasher->hash('');
    }
    public function testHashSuccess(): void
    {
        $hasher = new PasswordHasher(32);
        $hash = $hasher->hash($password = 'test_password');

        self::assertNotEmpty($hash);
        self::assertNotEquals($password, $hash);
    }

    public function testHashValidate(): void
    {
        $hasher = new PasswordHasher(32);
        $hash = $hasher->hash($password = 'test_password');

        self::assertFalse($hasher->validate('corrupted', $hash));
        self::assertTrue($hasher->validate($password, $hash));
        
    }
}