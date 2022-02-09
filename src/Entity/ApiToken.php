<?php

namespace App\Entity;

use App\Repository\ApiTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApiTokenRepository::class)
 */
class ApiToken
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $token;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?\DateTimeImmutable $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="token")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->token = sha1(uniqid('token'));
        $this->expiresAt = new \DateTimeImmutable('+ 1 day');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function isExpired():bool
    {
        return $this->getExpiresAt() <= new \DateTimeImmutable();
    }
}
