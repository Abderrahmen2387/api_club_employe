<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvitationRepository::class)
 */
class Invitation implements \JsonSerializable
{
    const STATUS_CANCELED = 'canceled';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $created_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $guest;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $status;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getGuest(): ?User
    {
        return $this->guest;
    }

    public function setGuest(?User $guest): self
    {
        $this->guest = $guest;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'comment' => $this->getComment(),
            'status' => $this->getStatus(),
            'sender' => $this->getSender()->getId(),
            'senderName' => $this->getSender()->getName(),
            'guest' => $this->getGuest()->getId(),
            'guestName' => $this->getGuest()->getName(),
            'create_at' => $this->getCreatedAt()
        ];
    }
}
