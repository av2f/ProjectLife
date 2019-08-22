<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 */
class Subscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="subscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscriber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubscribType", inversedBy="subscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscriberType;

    /**
     * @ORM\Column(type="datetime")
     */
    private $subscribPaidAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $subscribBeginAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $subscribEndAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriber(): ?User
    {
        return $this->subscriber;
    }

    public function setSubscriber(?User $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    public function getSubscriberType(): ?SubscribType
    {
        return $this->subscriberType;
    }

    public function setSubscriberType(?SubscribType $subscriberType): self
    {
        $this->subscriberType = $subscriberType;

        return $this;
    }

    public function getSubscribPaidAt(): ?\DateTimeInterface
    {
        return $this->subscribPaidAt;
    }

    public function setSubscribPaidAt(\DateTimeInterface $subscribPaidAt): self
    {
        $this->subscribPaidAt = $subscribPaidAt;

        return $this;
    }

    public function getSubscribBeginAt(): ?\DateTimeInterface
    {
        return $this->subscribBeginAt;
    }

    public function setSubscribBeginAt(\DateTimeInterface $subscribBeginAt): self
    {
        $this->subscribBeginAt = $subscribBeginAt;

        return $this;
    }

    public function getSubscribEndAt(): ?\DateTimeInterface
    {
        return $this->subscribEndAt;
    }

    public function setSubscribEndAt(\DateTimeInterface $subscribEndAt): self
    {
        $this->subscribEndAt = $subscribEndAt;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
