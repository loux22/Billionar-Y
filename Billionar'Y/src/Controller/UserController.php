<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\User;
use App\Entity\Member;
use App\Form\UserType;
use App\Form\UserModifyType;
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
    public function profil(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $avatarUser = $user -> getAvatar();
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
        $lastAvatar = $user -> getAvatar();

        // modifier profil
        $form = $this -> createForm(UserModifyType::class, $user);
        $form -> handleRequest($request);
        $avatar = 1;

        if($form -> isSubmitted() && $form -> isValid()){
            if($user -> getAvatar()){
                $user -> removeFile();
                $user -> fileUpload();
            }else{
                $user -> setAvatar($avatarUser);
            }


            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($user); //commit(git)
            $manager -> flush(); // push(git)

            $this -> addFlash('success','Vous avez bien modifier votre profil');
        }

        //Changer mot de passe
        $userNewPassword = $request->request->all();
        $actuelPassword = $user->getPassword();
        if(isset($userNewPassword['lastPassword'])){
            $userLastPassword = $userNewPassword['lastPassword'];
            $NewPassword = $userNewPassword['newPassword'];
            $userRptNewPassword = $userNewPassword['repeatNewPassword'];
            if (password_verify($userLastPassword, $actuelPassword)) {
                    if($NewPassword == $userRptNewPassword) {

                        if(strlen($NewPassword) >= 8) {
                            $newUser = new User; 
                            $password = $passwordEncoder->encodePassword($newUser, $NewPassword);
                            $user -> setPassword($password);
                            $manager = $this-> getDoctrine() -> getManager();
                            $manager -> persist($user); //commit(git)
                            $manager -> flush(); // push(git)
                            $this -> addFlash('success','Le mot de passe a été modifié !');
                        }else {
                            $this -> addFlash('errors','Le mot de passe doit faire minimum 8 caractères');
                        }
                        

        
                    } else {
                        $this -> addFlash('errors','Les deux mots de passe ne sont pas identiques');
                    }


            } else {
                $this -> addFlash('errors','Le mot de passse ne corresponds pas a celui actuel');
            }
            
        }

        return $this->render('user/profil.html.twig', [
            'member' => $member,
            'age' => $age,
            'UserModifyForm' => $form -> createView(),
            ]);
    }
    /**
     * @Route("/profilModifyPassword", name="profilModifyPassword")
     */
    public function profilModifyPassword(Request $request)
    {
        return $this->render('user/profilModifyPassword.html.twig', []);
    }
    
    /**
     * @Route("/modifyPassword", name="modifyPassword")
     */
    public function modifyPassword(Request $request)
    {
        return $this->render('user/passwordForget.html.twig', []);
    }



    /**
     * @Route("/recoverPassword", name="recoverPassword")
     */
    public function recoverPassword(){
        return $this->render('user/recoverPassword.html.twig');
    }

      /**
     * @Route("/profilHistoric", name="profilHistoric")
     */
    public function ProfilHistoric(){
        return $this->render('user/profilHistoric.html.twig');

    }

      /**
     * @Route("/support", name="support")
     */
    public function support(){
        return $this->render('user/support.html.twig');

}
}
