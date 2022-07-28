<?php


namespace App\Util;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait TLifecycleCallback
{

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\PrePersist]
    public function createdAt(): void
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new DateTimeImmutable();
        }
        if (empty($this->updatedAt)) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    #[ORM\PreUpdate]
    public function updatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
