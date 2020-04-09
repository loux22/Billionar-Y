<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/dashboard/admin", name="adminDashboard")
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
     * @Route("/dashboardPanel/admin", name="adminDashboardPanel")
     */
    public function userDashboardPanel()
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

        return $this->render('admin/dashboardPanel.html.twig', [
            'navbar' => $navbar
        ]);
    }

}
