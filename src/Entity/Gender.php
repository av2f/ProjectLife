<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenderRepository")
 */
class Gender
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="gender")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $gender_fr;

    public function __construct()
    {
        $this->gender = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getGender(): Collection
    {
        return $this->gender;
    }

    public function addGender(User $gender): self
    {
        if (!$this->gender->contains($gender)) {
            $this->gender[] = $gender;
            $gender->setGender($this);
        }

        return $this;
    }

    public function removeGender(User $gender): self
    {
        if ($this->gender->contains($gender)) {
            $this->gender->removeElement($gender);
            // set the owning side to null (unless already changed)
            if ($gender->getGender() === $this) {
                $gender->setGender(null);
            }
        }

        return $this;
    }

    public function getGenderFr(): ?string
    {
        return $this->gender_fr;
    }

    public function setGenderFr(string $gender_fr): self
    {
        $this->gender_fr = $gender_fr;

        return $this;
    }

}
