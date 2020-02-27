<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Member;
use App\Entity\Note;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $userlog = $this->getUser();
        if($userlog != null){
            return $this->redirectToRoute('games');
        }
        $user = new User;
        $member = new Member;

        $form = $this -> createForm(UserType::class, $user);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $user->setDateU(new \DateTime());
            $user->setIsActive(true);
            $user->setAvatar('0.png');
            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($user); //commit(git)
            $manager -> flush(); // push(git)

            $member->setUser($user);
            $member->setBank(0);
            $manager -> persist($member); //commit(git)
            $manager -> flush(); // push(git)

            $this -> addFlash('success','Vous étes inscris');
            return $this->redirectToRoute('login');
        }
        return $this->render('user/register.html.twig', ['UserForm' => $form -> createView()]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $userlog = $this->getUser();
        if($userlog != null){
            return $this->redirectToRoute('signup');
        }
        $lastUsername = $authenticationUtils -> getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        if($error){
            $this -> addFlash('errors', 'erreur d\'authentification');
        }
        return $this->render('user/login.html.twig', [
            'lastUsername' => $lastUsername
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil()
    {
        $user = $this->getUser();
        if($user === null){
            return $this->redirectToRoute('login');
        }

        $repository = $this-> getDoctrine() -> getRepository(Member::class);
        $member = $repository -> getUserProfil($user);

        $u = $user->getAge();
        $stringValue = $u->format('Y-m-d H:i:s');
        $datetime1 = new \DateTime(); // date actuelle
        $datetime2 = new \DateTime($stringValue);
        $age = $datetime1->diff($datetime2, true)->y; // le y = nombre d'années ex : 22

        
        return $this->render('user/profil.html.twig', [
            'member' => $member,
            'age' => $age,
            ]);
    }
    
    /**
     * @Route("/modifyPassword", name="modifyPassword")
     */
    public function modifyPassword(Request $request)
    {
        $user = $this->getUser();
        if($user === null){
         return $this->redirectToRoute('login');
         }

        $form = $this -> createForm(UserType::class, $user);
        $repository = $this-> getDoctrine() -> getRepository(Member::class);
        $member = $repository -> getUserProfil($user);
        $u = $user->getAge();
        $stringValue = $u->format('Y-m-d H:i:s');
        $datetime1 = new \DateTime(); // date actuelle
        $datetime2 = new \DateTime($stringValue);
        $age = $datetime1->diff($datetime2, true)->y; // le y = nombre d'années ex : 22

        return $this->render('user/profil.html.twig', [
            'member' => $member,
            'age' => $age,
            ]);
    }
    /**
     * @Route("/password/forget", name="passwordForget")
     * 
     */
    public function passwordForget()
    {
        return $this->render('user/passwordForget.html.twig', [
            ]);
    }
}
