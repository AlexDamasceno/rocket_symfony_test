<?php

namespace App\Entity;

use App\Repository\WebsiteHandlerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WebsiteHandlerRepository::class)
 */
class WebsiteHandler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=WebsiteStatus::class, mappedBy="website")
     */
    private $websiteStatus;

    public function __construct()
    {
        $this->websiteStatus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    /**
     * @return Collection|WebsiteStatus[]
     */
    public function getWebsiteStatus(): Collection
    {
        return $this->websiteStatus;
    }

    public function addWebsiteStatus(WebsiteStatus $websiteStatus): self
    {
        if (!$this->websiteStatus->contains($websiteStatus)) {
            $this->websiteStatus[] = $websiteStatus;
            $websiteStatus->setWebsite($this);
        }

        return $this;
    }

    public function removeWebsiteStatus(WebsiteStatus $websiteStatus): self
    {
        if ($this->websiteStatus->removeElement($websiteStatus)) {
            // set the owning side to null (unless already changed)
            if ($websiteStatus->getWebsite() === $this) {
                $websiteStatus->setWebsite(null);
            }
        }

        return $this;
    }
}
