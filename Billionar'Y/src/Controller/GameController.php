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
        $member = $rep->findAll();



        return $this->render('game/ranking_winning.html.twig', ['ranking' => $ranking]);
    }
}
