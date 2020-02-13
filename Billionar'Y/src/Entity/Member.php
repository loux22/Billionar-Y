<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $postal;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $ipAdress;

    /**
     * @ORM\Column(type="integer")
     */
    private $bank;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RankingWinning", mappedBy="id_member")
     */
    private $rankingWinnings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="member")
     */
    private $notes;

    public function __construct()
    {
        $this->rankingWinnings = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(?string $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getIpAdress(): ?string
    {
        return $this->ipAdress;
    }

    public function setIpAdress(?string $ipAdress): self
    {
        $this->ipAdress = $ipAdress;

        return $this;
    }

    public function getBank(): ?int
    {
        return $this->bank;
    }

    public function setBank(int $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|RankingWinning[]
     */
    public function getRankingWinnings(): Collection
    {
        return $this->rankingWinnings;
    }

    public function addRankingWinning(RankingWinning $rankingWinning): self
    {
        if (!$this->rankingWinnings->contains($rankingWinning)) {
            $this->rankingWinnings[] = $rankingWinning;
            $rankingWinning->setIdMember($this);
        }

        return $this;
    }

    public function removeRankingWinning(RankingWinning $rankingWinning): self
    {
        if ($this->rankingWinnings->contains($rankingWinning)) {
            $this->rankingWinnings->removeElement($rankingWinning);
            // set the owning side to null (unless already changed)
            if ($rankingWinning->getIdMember() === $this) {
                $rankingWinning->setIdMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setMember($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getMember() === $this) {
                $note->setMember(null);
            }
        }

        return $this;
    }
}
