<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this -> createForm(ContactType::class);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            $contact = $form->getData();
            // dd($contact); dump data c'est genial

            // on envoie le mail
            $message = (new \Swift_Message('title'))
            // on attribue l'expediteur
                ->setFrom($contact['email'])
            // on attribue le destinataire
                ->setTo('louis.ardilly@yahoo.fr')  
            // on crée le messsage avec la vue twig
                ->setBody(
                    $this -> renderView(
                        'emails/contact.html.twig', compact('contact')
                        ),
                    'text/html'
                    );  
                    // on envoie le mail
                    $mailer->send($message);
                    $this -> addFlash('success','Votre mail a bien été envoyer');

        }


        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form -> createView()
        ]);
    }
}
