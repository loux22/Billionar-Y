<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Note;
use App\Entity\User;
use App\Entity\Member;
use App\Entity\RankingWinning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{

     /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('game/home.html.twig', []);
    }

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

        $repoo = $this->getDoctrine()->getRepository(User::class);
        $user = $repoo->findAll(); 

        return $this->render('game/ranking_winning.html.twig', ['ranking' => $ranking]);
    }

    /**
     * @Route("/games", name="games")
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
    public function game($id, Request $request)
    {
        $manager = $this-> getDoctrine() -> getManager();
        $game = $manager -> find(Game::class, $id);

        $repo = $this-> getDoctrine() -> getRepository(Note::class);
        $note = $repo -> note($id);

        $game1 = $request->request->all();
        // if($game1){
        //     $game1 = $game1['num1'];
        // }
      
       

        return $this->render('game/game.html.twig', [
            'game' => $game,
            'note' => $note,
            'game1' => $game1
            ]);
    }
}
