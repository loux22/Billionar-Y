<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\Validator\Constraints as Error;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="mail", message="Le mail existe déja")
 * @UniqueEntity(fields="pseudo", message="le pseudo existe deja")
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
     * @ORM\Column(type="string", length=30)
     * @Error\Length(min=3, max=30, minMessage="ton username '{{ value }}' est trop court", 
     * maxMessage="Ton username '{{ value }}' est trop long")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=30)
     * @Error\Length(min=3, max=30, minMessage="Ton lastname '{{ value }}' est trop court", 
     * maxMessage="Ton lastname '{{ value }}' est trop long") 
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     * Error\Email(
     *     message = "Ton Email '{{ value }}' n'est pas valide.")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=100)
     * @Error\length(min="8", minMessage="ton mot de passe doit contenir au moins 8 caractere")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $avatar;

    /**
     * @ORM\Column(type="date")
     */
    private $date_u;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=50)
     * @Error\Length(min=3, max=30, minMessage="ton username '{{ value }}' est trop court", 
     * maxMessage="Ton username '{{ value }}' est trop long")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="date")
     */
    private $age;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Historic", mappedBy="user")
     */
    private $historics;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->historics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateU(): ?\DateTimeInterface
    {
        return $this->date_u;
    }

    public function setDateU(\DateTimeInterface $date_u): self
    {
        $this->date_u = $date_u;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
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

    public function getRoles(){
        return $this->roles;
    }

    public function eraseCredentials(){

    }

    public function getSalt()
    {
        return null;
    }

    public function getAge(): ?\DateTimeInterface
    {
        return $this->age;
    }

    public function setAge(\DateTimeInterface $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection|Historic[]
     */
    public function getHistorics(): Collection
    {
        return $this->historics;
    }

    public function addHistoric(Historic $historic): self
    {
        if (!$this->historics->contains($historic)) {
            $this->historics[] = $historic;
            $historic->setUser($this);
        }

        return $this;
    }

    public function removeHistoric(Historic $historic): self
    {
        if ($this->historics->contains($historic)) {
            $this->historics->removeElement($historic);
            // set the owning side to null (unless already changed)
            if ($historic->getUser() === $this) {
                $historic->setUser(null);
            }
        }

        return $this;
    }
}
