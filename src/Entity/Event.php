<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Cocur\Slugify\Slugify;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @Assert\Type(type="App\Entity\Address")
     * @Assert\Valid(groups={"saveWithAddress"})
     */
    protected $newAddress;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"save", "saveWithAddress"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(groups={"save", "saveWithAddress"})
     */
    private $beginsAt;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(groups={"save", "saveWithAddress"})
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(groups={"save", "saveWithAddress"})
     */
    private $endsAt;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"save", "saveWithAddress"})
     */
    private $subscriptionsMax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"save", "saveWithAddress"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=20, columnDefinition="enum('Being created','In process', 'Open', 'Closed', 'Cancelled')")
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_picture;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="eventsCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="event")
     */
    private $subscriptions;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class, inversedBy="events", cascade="persist")
     * @Assert\NotBlank(groups={"save"})
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

    public function getNewAddress()
    {
        return $this->newAddress;
    }

    public function setNewAddress(Address $address = null)
    {
        $this->newAddress = $address;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setEvent($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getEvent() === $this) {
                $subscription->setEvent(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBeginsAt(): ?DateTimeInterface
    {
        return $this->beginsAt;
    }

    public function setBeginsAt($beginsAt): self
    {
        $this->beginsAt = $beginsAt;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getEndsAt(): ?\DateTime
    {
        return $this->endsAt;
    }

    public function setEndsAt( $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function getSubscriptionsMax(): ?int
    {
        return $this->subscriptionsMax;
    }

    public function getSlug(): String
    {
        return (new Slugify())->slugify($this->title);
    }

    public function setSubscriptionsMax(int $subscriptionsMax): self
    {
        $this->subscriptionsMax = $subscriptionsMax;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrlPicture()
    {
        return $this->url_picture;
    }

    /**
     * @param mixed $url_picture
     */
    public function setUrlPicture($url_picture): void
    {
        $this->url_picture = $url_picture;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }


}
