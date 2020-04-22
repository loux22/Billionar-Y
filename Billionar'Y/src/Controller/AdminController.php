<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Historic;
use App\Entity\Member;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/loginAdmin", name="loginAdmin")
     */
    public function login()
    {
        return $this->render('admin/loginAdmin.html.twig', []);
    }


    /**
     * @Route("/dashboard/admin/users", name="userTable")
     */
    public function userTable()
    {
        $navbar = false;
        $user = $this->getUser();
        if($user === null){
            return $this->redirectToRoute('login');
        }
        $repoMember = $this->getDoctrine()->getRepository(Member::class);
        $members = $repoMember->allUser(10);

        $repoHistoric = $this->getDoctrine()->getRepository(Historic::class);
        $earningUser = $repoHistoric -> moneyByUser();

        return $this->render('admin/userTable.html.twig', [
            'navbar' => $navbar,
            'user' => $user,
            'members' => $members,
            'earningUser' => $earningUser
        ]);
    }


    /**
     * @Route("/dashboard/admin/deactivate/user/{id}", name="deactivateUser")
     */
    public function deactivateUser($id)
    {
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repoUser->findOneBy([
            'id' => $id
        ]);
        
        if($user -> getIsActive() === true){
            $user -> setIsActive(false);
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('userTable');
    }

    /**
     * @Route("/dashboard/admin/reactivate/user/{id}", name="reactivateUser")
     */
    public function reactivateUser($id)
    {
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repoUser->findOneBy([
            'id' => $id
        ]);
        
        if($user -> getIsActive() === false){
            $user -> setIsActive(true);
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('userTable');
    }


    /**
     * @Route("/dashboard/admin/games", name="adminDashboardGames")
     */
    public function userDashboard()
    {
        $navbar = false;
        $user = $this->getUser();
        if($user === null){
            return $this->redirectToRoute('login');
        }
        $repoGame = $this->getDoctrine()->getRepository(Game::class);
        $games = $repoGame->findAll();

        
        return $this->render('admin/dashboard.html.twig', [
            'navbar' => $navbar,
            'games' => $games,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/dashboard/admin", name="adminDashboard")
     */
    public function userDashboardPanel()
    {
        $navbar = false;
        $user = $this->getUser();
        if($user === null){
            return $this->redirectToRoute('login');
        }
        $repoGame = $this->getDoctrine()->getRepository(Game::class);
        $nbParty = $repoGame->findNbParty();
        $nbGame = $repoGame->findNbGames(true);

        $repoHistoric = $this->getDoctrine()->getRepository(Historic::class);
        $money =  $repoHistoric->money();
        $money = $money[0]['total'] - ($money[0]['nbParty'] * 2);


        return $this->render('admin/dashboardPanel.html.twig', [
            'navbar' => $navbar,
            'nbParty' => $nbParty[0],
            'nbGame' => $nbGame[0],
            'money' => $money,
            'user' => $user
        ]);
    }

    /**
     * @Route("/dashboard/admin/game/{id}", name="adminDashboardGame")
     */
    public function userDashboardGames($id, Request $request)
    {
        $navbar = false;
        $user = $this->getUser();
        if($user === null){
            return $this->redirectToRoute('login');
        }
        $repoGame = $this->getDoctrine()->getRepository(Game::class);
        $game = $repoGame->findBy([
            'id' => $id
        ]);
        $repoHistoric = $this->getDoctrine()->getRepository(Historic::class);
        $g = $repoHistoric->moneyByGame($game); //earnings == gains en frenchies
        $earnings = ($g[0]['nbParty'] * 2) - $g[0]['total'];

        $isActive = $request->request->all();
        if(isset($isActive['submit'])){
            if (isset($isActive['checkOn'])) {
                $game[0]->setIsActive(true);
            } else {
                $game[0]->setIsActive(false);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($game[0]);
            $manager->flush();
        }
        




        return $this->render('admin/dashboardGames.html.twig', [
            'navbar' => $navbar,
            'g' => $g[0],
            'earnings' => $earnings,
            'game' => $game[0],
            'isActive' => $isActive,
            'user' => $user
        ]);
    }
}
