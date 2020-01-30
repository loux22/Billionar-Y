<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RankingWinningRepository")
 */
class RankingWinning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $winning;

    /**
     * @ORM\Column(type="date")
     */
    private $date_r;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="rankingWinnings")
     */
    private $id_member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="rankingWinnings")
     */
    private $id_game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWinning(): ?int
    {
        return $this->winning;
    }

    public function setWinning(int $winning): self
    {
        $this->winning = $winning;

        return $this;
    }

    public function getDateR(): ?\DateTimeInterface
    {
        return $this->date_r;
    }

    public function setDateR(\DateTimeInterface $date_r): self
    {
        $this->date_r = $date_r;

        return $this;
    }

    public function getIdMember(): ?Member
    {
        return $this->id_member;
    }

    public function setIdMember(?Member $id_member): self
    {
        $this->id_member = $id_member;

        return $this;
    }

    public function getIdGame(): ?Game
    {
        return $this->id_game;
    }

    public function setIdGame(?Game $id_game): self
    {
        $this->id_game = $id_game;

        return $this;
    }
}
