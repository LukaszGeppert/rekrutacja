<?php

declare(strict_types=1);

namespace Wise\User\ApiAdmin\Dto\Traders;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;
use Wise\Core\Dto\AbstractDto;

class PutTraderDto extends AbstractDto
{
    #[OA\Property(
        description: 'ID nadawane przez system ERP',
        example: 'TRADER-123',
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: "Id handlowca nadawane przez system ERP, może mieć maksymalnie {{ limit }} znaków",
    )]
    protected string $id;

    #[OA\Property(
        description: 'ID wewnętrzne systemu B2B. Można używać zamiennie z id (o ile jest znane). Jeśli podane, ma priorytet względem id.',
        example: 1,
    )]
    protected ?int $internalId;

    #[OA\Property(
        description: 'Imię handlowca',
        example: 'Jan',
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: "Imię handlowca, może mieć maksymalnie {{ limit }} znaków",
    )]
    protected string $firstName;

    #[OA\Property(
        description: 'Nazwisko handlowca',
        example: 'Nowak',
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: "Nazwisko handlowca, może mieć maksymalnie {{ limit }} znaków",
    )]
    protected string $lastName;

    #[OA\Property(
        description: 'Email handlowca',
        example: 'trader@example.com',
    )]
    #[Assert\Length(
        max: 60,
        maxMessage: "Email handlowca, może mieć maksymalnie {{ limit }} znaków",
    )]
    protected string $email;

    #[OA\Property(
        description: 'Telefon',
        example: '+48777444777',
    )]
    #[Assert\Length(
        max: 60,
        maxMessage: "Telefon, może mieć maksymalnie {{ limit }} znaków",
    )]
    protected string $phone;

    #[OA\Property(
        description: 'Czy domyślny?',
        example: true,
    )]
    protected bool $isDefault;

    #[OA\Property(
        description: 'Czy aktywny?',
        example: true,
    )]
    protected bool $isActive;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getInternalId(): ?int
    {
        return $this->internalId;
    }

    public function setInternalId(?int $internalId): self
    {
        $this->internalId = $internalId;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
