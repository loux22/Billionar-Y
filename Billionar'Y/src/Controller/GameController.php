<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Member;
use App\Entity\RankingWinning;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/ranking_winning", name="ranking_winning")
     */
    public function ranking_winning()
    {
        $repository = $this->getDoctrine()->getRepository(RankingWinning::class);
        $ranking = $repository->findRankingEarnings();

        $repo = $this->getDoctrine()->getRepository(Member::class);
        $member = $repo->findAll();

        $rep = $this->getDoctrine()->getRepository(Game::class);
        $game = $rep->findAll();

        return $this->render('game/ranking_winning.html.twig', ['ranking' => $ranking]);
    }

    /**
     * @Route("/games", name="liste_game")
     */
    public function liste_game()
    {
        $rep = $this->getDoctrine()->getRepository(Game::class);
        $games = $rep->findAll();

        return $this->render('game/games.html.twig', ['games' => $games]);
    }


    /**
     * @Route("/game/{id}", name="game")
     */
    public function game($id)
    {
        $manager = $this-> getDoctrine() -> getManager();
        $game = $manager -> find(Game::class, $id);

        return $this->render('game/game.html.twig', ['game' => $game]);
    }
}
