<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Historic;
use App\Entity\Note;
use App\Entity\User;
use App\Entity\Member;
use App\Entity\RankingWinning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{
    public function getMember(){
        $navbar = true;
        $user = $this->getUser();
        $repository = $this-> getDoctrine() -> getRepository(Member::class);
        $member = $repository -> findBy([
            'user' => $user
        ]);
        return $member;
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {   
        $navbar = true;
        $user = $this -> getUser();
        $member = $this -> getMember();
        $rep = $this->getDoctrine()->getRepository(Game::class);
        $games = $rep->findAll();
        if($user != null){
        $member = $member[0];
        }
        
        return $this->render('game/home.html.twig', [
            'member' => $member,
            'navbar' => $navbar,
            'games' => $games
        ]);
    }

    /**
     * @Route("/ranking_winning/{id}", name="ranking_winning")
     */
    public function ranking_winning($id, Request $request)
    {
        $navbar = true;
        $member = $this -> getMember();
        $currentRoute = $request->attributes->get('_route');
        $currentUrl = $this->get('router')->generate($currentRoute, array('id' => $id), true);
        $currentUrl = substr($currentUrl, -1);
        $currentUrl = intval($currentUrl);

        if ($currentUrl < 1 || $currentUrl > 5) {
            return $this->redirectToRoute(
                'ranking_winning',
                [
                    'id' => 1
                ]
            );
        }

        $repository = $this->getDoctrine()->getRepository(RankingWinning::class);
        $rank = $repository->findRankingEarnings();

        $repo = $this->getDoctrine()->getRepository(Member::class);
        $member = $repo->findAll();

        $rep = $this->getDoctrine()->getRepository(Game::class);
        $game = $rep->findAll();

        $repoo = $this->getDoctrine()->getRepository(User::class);
        $user = $repoo->findAll();

        $ranking = [];
        foreach ($rank as $key => $value) {
            if ($key >= 20 * ($id - 1) && $key <= (20 * ($id - 1) + 19)) {
                $ranking[] = $value;
            }
        }
        $member = $member[0];
        return $this->render('game/ranking_winning.html.twig', [
            'ranking' => $ranking,
            'id' => $id,
            'member' => $member,
            'navbar' => $navbar
        ]);
    }

    /**
     * @Route("/games", name="games")
     */
    public function liste_game()
    {
        $navbar = true;
        $member = $this -> getMember();
        $member = $member[0];
        $rep = $this->getDoctrine()->getRepository(Game::class);
        $games = $rep->findAll();

        return $this->render('game/games.html.twig', [
            'games' => $games,
            'member' => $member,
            'navbar' => $navbar
            ]);
    }


    /**
     * @Route("/game/{id}", name="game")
     */
    public function game($id, Request $request)
    {
        $navbar = true;
        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute('login');
        }
        $repository = $this->getDoctrine()->getRepository(Member::class);
        $member = $repository->getUserProfil($user);
        $member = $member[0];

        $manager = $this->getDoctrine()->getManager();
        $game = $manager->find(Game::class, $id);

        $repo = $this->getDoctrine()->getRepository(Note::class);
        $note = $repo->note($id);

        $repo = $this->getDoctrine()->getRepository(Historic::class);
        $historic = $repo->findBy([
            'date' => new \DateTime(),
            'game' => $game
        ]);

        $game1 = $request->request->all();

        if (isset($game1['winning'])) {
            if ($game1['winning'] == 0) {
                $member->setBank($member->getBank() - 2);
                $this->addFlash('errors', 'tu as perdu');
            } elseif ($game1['winning'] == 1) {
                $member->setBank($member->getBank() - 1);
                $this->addFlash('success', 'tu n\'a perdu que 1 euro');
            } elseif ($game1['winning'] == 4) {
                $member->setBank($member->getBank() + 2);
                $this->addFlash('success', 'tu as gagné 2 euros');
            } elseif ($game1['winning'] == 10) {
                $member->setBank($member->getBank() + 8);
                $this->addFlash('success', 'tu as gagné 8 euros');
            } elseif ($game1['winning'] >= 100) {
                $member->setBank($member->getBank() + 98);
                $this->addFlash('success', 'jackpot');
            }
            if($game1['winning'] > 0){
                $ranking = new RankingWinning();
                $ranking
                ->setIdMember($member)
                ->setIdGame($game)
                ->setWinning($game1['winning'])
                ->setDateR(new \DateTime());
                $manager->persist($ranking);
            }


            if (empty($historic)) {
                $historic = new Historic();
                $historic
                    ->setGame($game)
                    ->setUser($user)
                    ->setDate(new \DateTime())
                    ->setNbParty(1)
                    ->setTotal($game1['winning']);
                $manager->persist($historic);
            } else {
                $historic[0]
                    ->setNbParty($historic[0]->getNbParty() + 1)
                    ->setTotal($historic[0]->getTotal() + $game1['winning']);
                $manager->persist($historic[0]);
            }
            $manager->persist($member);
            $manager->flush();
        }
        $repoHistoric = $this->getDoctrine()->getRepository(Historic::class);
        $myHistoric = $repoHistoric -> findBy([
            'user' => $user
        ]);
        $repoRanking = $this->getDoctrine()->getRepository(RankingWinning::class);
        $ranking = $repoRanking -> HistoricRankingEarnings($game);

        return $this->render('game/game.html.twig', [
            'game' => $game,
            'note' => $note,
            'member' => $member,
            'game1' => $game1,
            'navbar' => $navbar,
            'myHistoric' => $myHistoric,
            'ranking' => $ranking,
            'id' => $id
        ]);
    }

    /**
     * @Route("/gametwo/{id}", name="gametwo")
     */
    public function gamestwo()
    {

        $navbar = true;
        $member = $this -> getMember();
        $member = $member[0];
        return $this->render('game/gamestwo.html.twig', [
            'navbar' => $navbar,
            'member' => $member
        ]);
    }

}
