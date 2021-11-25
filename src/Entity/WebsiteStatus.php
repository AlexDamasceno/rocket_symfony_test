<?php

namespace App\Entity;

use App\Repository\WebsiteStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WebsiteStatusRepository::class)
 */
class WebsiteStatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=WebsiteHandler::class, inversedBy="websiteStatus")
     */
    private $website;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

   /**
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebsite(): ?WebsiteHandler
    {
        return $this->website;
    }

    public function setWebsite(?WebsiteHandler $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
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
}
