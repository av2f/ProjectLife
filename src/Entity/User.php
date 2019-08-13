<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @UniqueEntity(
 *  fields = {"pseudo"},
 *  message = "Ce pseudonyme existe déjà, merci d'en choisir un autre")
 * )
 * 
 * @UniqueEntity(
 *  fields = {"email"},
 *  message = "Cette adresse mail existe déjà, merci d'en choisir une autre")
 * )
 * 
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *  message = "Veuillez saisir un pseudonyme"
     * )
     * @Assert\Length(
     *  min=5,
     *  minMessage="le mot de passe doit contenir au moins {{ limit }} caractères ou chiffres"
     * )
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *  message = "Veuillez saisir une adresse mail"
     * )
     * @Assert\Email(
     *  message = "Veuillez saisir une adresse mail valide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *  message="Veuillez saisir un mot de passe (8 car. min)"
     * )
     * @Assert\Length(
     *  min=8,
     *  minMessage="le mot de passe doit contenir au moins {{ limit }} caractères"
     * )
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $avatar;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotNull(
     *  message="Veuillez renseigner votre date de naissance"
     * )
     */
    private $birthdayDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gender", inversedBy="gender")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate(\DateTimeInterface $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    // functions for implementation of UserInterface
    public function getUsername()
    {
        return $this->pseudo;
    }
    public function getRoles() {
        return array('ROLE_USER');
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    public function eraseCredentials() {}
    

    // lifecycleCallbacks functions

    /**
     * Generate the date of creation of profile in prePersist
     * 
     * @ORM\PrePersist
     *
     * @return void
     */
    public function setCreatedAtDate(){
        $this->createdAt = new \DateTime();
    }

    /**
     * Generate the date of last modified date of profile in preUpdate
     * 
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function setModifiedAtDate(){
        $this->modifiedAt = new \DateTime();
    }

    /**
     * Caclculate age with birthday date
     * Author : Frederic Parmentier
     * Created at : 2019/08/07
     *
     * @return void
     */
    public function getCalculateAge(){
        $today = new \DateTime('now');
        $age = $today->diff($this->getBirthdayDate());
        return $age->format('%y');
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
}
