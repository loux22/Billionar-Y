<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Historic;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/userTable", name="userTable")
     */
    public function userTable()
    {
        $navbar = false;
        return $this->render('admin/userTable.html.twig', [
            'navbar' => $navbar
        ]);
    }


    /**
     * @Route("/dashboard/admin/games", name="adminDashboardGames")
     */
    public function userDashboard()
    {
        $navbar = false;
        // $this->denyAccessUnlessGranted('ROLE_MEMBER');
        // $navbar = false;
        // $userLog = $this->getUser();

        // $repository = $this->getDoctrine()->getRepository(Member::class);
        // $member = $repository->getUserProfil($userLog);
        // $member = $member[0];

        // $repoGame = $this->getDoctrine()->getRepository(Game::class);
        // $repoComment = $this->getDoctrine()->getRepository(Comment::class);

        // $nbDowloadGame = $repoGame->findNbDownload($member);
        // $nbGame = $repoGame->findNbGame($member);

        // $nbComments = $repoComment->FindAllCommentGame($member);
        // $nbComments = count($nbComments);

        return $this->render('admin/dashboard.html.twig', [
            'navbar' => $navbar
        ]);
    }

    /**
     * @Route("/dashboard/admin", name="adminDashboard")
     */
    public function userDashboardPanel()
    {
        $navbar = false;
        // $this->denyAccessUnlessGranted('ROLE_MEMBER');
        // $userLog = $this->getUser();

        // $repository = $this->getDoctrine()->getRepository(Member::class);
        // $member = $repository->getUserProfil($userLog);
        // $member = $member[0];

        $repoGame = $this->getDoctrine()->getRepository(Game::class);
        $nbParty = $repoGame->findNbParty();
        $nbGame = $repoGame->findNbGames(true);

        $repoHistoric = $this->getDoctrine()->getRepository(Historic::class);
        $money =  $repoHistoric->money();
        $money = $money[0]['total'] - ($money[0]['nbParty'] * 2) ;
        // $repoComment = $this->getDoctrine()->getRepository(Comment::class);

        // $nbDowloadGame = $repoGame->findNbDownload($member);
        

        // $nbComments = $repoComment->FindAllCommentGame($member);
        // $nbComments = count($nbComments);

        return $this->render('admin/dashboardPanel.html.twig', [
            'navbar' => $navbar,
            'nbParty' => $nbParty[0],
            'nbGame' => $nbGame[0],
            'money' => $money
        ]);
    }

    /**
     * @Route("/dashboard/admin/game", name="adminDashboardGame")
     */
    public function userDashboardGames()
    {
        $navbar = false;
        // $this->denyAccessUnlessGranted('ROLE_MEMBER');
        // $navbar = false;
        // $userLog = $this->getUser();

        // $repository = $this->getDoctrine()->getRepository(Member::class);
        // $member = $repository->getUserProfil($userLog);
        // $member = $member[0];

        // $repoGame = $this->getDoctrine()->getRepository(Game::class);
        // $repoComment = $this->getDoctrine()->getRepository(Comment::class);

        // $nbDowloadGame = $repoGame->findNbDownload($member);
        // $nbGame = $repoGame->findNbGame($member);

        // $nbComments = $repoComment->FindAllCommentGame($member);
        // $nbComments = count($nbComments);

        return $this->render('admin/dashboardGames.html.twig', [
            'navbar' => $navbar
        ]);
    }

    
}
