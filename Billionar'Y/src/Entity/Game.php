<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_g;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlay;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $img;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbNote;

    /**
     * @ORM\Column(type="integer")
     */
    private $winnings_max;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RankingWinning", mappedBy="id_game")
     */
    private $rankingWinnings;

    public function __construct()
    {
        $this->rankingWinnings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescriptionG(): ?string
    {
        return $this->description_g;
    }

    public function setDescriptionG(string $description_g): self
    {
        $this->description_g = $description_g;

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

    public function getNbPlay(): ?int
    {
        return $this->nbPlay;
    }

    public function setNbPlay(int $nbPlay): self
    {
        $this->nbPlay = $nbPlay;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNbNote(): ?int
    {
        return $this->nbNote;
    }

    public function setNbNote(int $nbNote): self
    {
        $this->nbNote = $nbNote;

        return $this;
    }

    public function getWinningsMax(): ?int
    {
        return $this->winnings_max;
    }

    public function setWinningsMax(int $winnings_max): self
    {
        $this->winnings_max = $winnings_max;

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
            $rankingWinning->setIdGame($this);
        }

        return $this;
    }

    public function removeRankingWinning(RankingWinning $rankingWinning): self
    {
        if ($this->rankingWinnings->contains($rankingWinning)) {
            $this->rankingWinnings->removeElement($rankingWinning);
            // set the owning side to null (unless already changed)
            if ($rankingWinning->getIdGame() === $this) {
                $rankingWinning->setIdGame(null);
            }
        }

        return $this;
    }
}
