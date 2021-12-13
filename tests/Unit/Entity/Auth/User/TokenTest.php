<?php

declare(strict_types=1);

namespace App\Unit\User;

use App\Entity\Auth\User\Token;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @covers \App\Entity\Auth\User\Token
 *
 * @internal
 */
final class TokenTest extends TestCase
{
    public function testTokenSuccess(): void
    {
        $token = new Token($value = Uuid::v6()->toRfc4122(), $validity = new DateTimeImmutable());

        self::assertEquals($value, $token->getValue());
        self::assertEquals($validity, $token->getValidity());
    }

    public function testValidateTokenSuccess(): void
    {
        $this->expectNotToPerformAssertions();

        $token = $this->createToken();

        $token->validate($token->getValue(), $token->getValidity()->modify('-1 secs'));
    }

    public function testTokenCase(): void
    {
        $value = Uuid::v6()->toRfc4122();
        $token = new Token(mb_strtoupper($value), new DateTimeImmutable());

        self::assertEquals($value, $token->getValue());
    }


    public function testTokenIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->createToken('123');
    }

    public function testTokenEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->createToken('');
    }

    public function testTokenInvalid(): void
    {
        $token = $this->createToken();

        $this->expectExceptionMessage('Token is invalid.');
        $token->validate($this->getUuid(), $token->getValidity()->modify('-1 secs'));
    }

    public function testTokenExpired(): void
    {
        $token = $this->createToken();

        $this->expectExceptionMessage('Token is expired.');
        $token->validate($token->getValue(), $token->getValidity()->modify('+1 secs'));
    }


    private function createToken($uuid = false): Token
    {
        return new Token(
            $uuid = ($uuid) ? $uuid : (($uuid === '') ? '' : $this->getUuid()),
            new DateTimeImmutable()
        );
    }

    private function getUuid(): string
    {

        return Uuid::v6()->toRfc4122();
    }
}
