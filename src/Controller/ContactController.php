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

    #[Route('/contact', name: 'app_contact')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = new Email();
        $email->from('anthony@gmail.com')
                ->to('contact@petittheatredelaruelle.be')
                ->cc('anthony@gmail.com')
                ->subject('Menu de la cantine')
                ->text('Le menu de ce mardi: Américain/Frites, salade et dessert')
                ->html("<h2> Hrttrtr!</h2><style>h2 {color: red};</style>");
        $mailer->send($email);
        $this->addFlash(
            'success',
            'E-mail envoyé avec succès!'
        );
        return $this->redirectToRoute('home', [
        ]);
    }



    /*
    #[Route('/mail', name: 'app_email')]
    public function contact(MailerInterface $mailer, \Symfony\Component\HttpFoundation\Request $request) :Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = new Email();
            $email->from($contact->getEmail());
            $email->to('info@iepscf-namur.be');
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

    #[Route('template', name: 'app_template')]
    public function template(MailerInterface $mailer, \Symfony\Component\HttpFoundation\Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = new TemplatedEmail();
            $email->from($contact->getEmail());
            $email->to('admin@iepscf-namur.be');
            $email->subject($contact->getSubject());
            $email->htmlTemplate('contact/email-css.html.twig');
            $email->context(
                [
                    'firstName' => $contact->getFirstName(),
                    'lastName' => $contact->getLastName(),
                    'message' => $contact->getMessage(),
                    'title' => $contact->getSubject(),
                ]
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
    */
}