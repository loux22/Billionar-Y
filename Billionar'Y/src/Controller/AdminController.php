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
     * @Route("/userTable", name="userTable")
     */
    public function userTable()
    {
        return $this->render('admin/userTable.html.twig', []);
    }

}
