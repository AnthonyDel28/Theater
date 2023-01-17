<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/mail', name: 'app_contactus')]
    public function contact(MailerInterface $mailer, \Symfony\Component\HttpFoundation\Request $request) :Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = new Email();
            $email->from($contact->getEmail());
            $email->to('contact@petittheatredelaruelle.be');
            $email->subject($contact->getSubject());
            // $email->text($contact->getMessage());
            $email->html(
                '
                    <p>' . $contact->getMessage() . '</p>
                    <p><small>' . $contact->getfirstName() . '</small></p>
                '
            );
            $mailer->send($email);
            $this->addFlash(
                'success',
                'E-mail envoyé avec succès!'
            );
            return $this->redirectToRoute('home', [
            ]);
        }
        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}