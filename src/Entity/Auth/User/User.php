<?php

namespace App\Entity\Auth\User;

use App\Repository\Auth\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`auth_users`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="user_id")
     */
    private Id $id;

    /**
     * @ORM\Column(type="user_status", length=32)
     */
    private Status $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @ORM\Column(type="user_email", unique=true)
     */
    private Email $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $passwordHash;

    /**
     * @ORM\Embedded(class="Token")
     */
    private ?Token $confirmToken = null;

    /**
     * @ORM\Embedded(class="Token")
     */
    private ?Token $passwordResetToken = null;



    private function __construct(Id $id, DateTimeImmutable $date, Email $email, Status $status)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->status = $status;
    }

    public static function addByEmail(Id $id, DateTimeImmutable $date, Email $email, string $passwordHash, Token $token): self
    {
        $user = new self($id, $date, $email, Status::wait());
        $user->passwordHash = $passwordHash;
        $user->confirmToken = $token;
        return $user;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function isWait(): bool
    {
        return $this->status->isWait();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getConfirmToken(): ?Token
    {
        return $this->confirmToken;
    }

    public function getPasswordResetToken(): ?Token
    {
        return $this->passwordResetToken;
    }

}
