<?php

namespace Infrastructure\Symfony\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['group1', 'group2'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['group3'])] // Only include in group3
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['group1', 'group2'])]
    private ?string $email = null;

    #[ORM\Column(length: 200)]
    #[Groups(['group1'])]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
