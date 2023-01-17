<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Emails;
use App\Form\AdminEmailFormType;
use App\Repository\ContactRepository;
use App\Repository\EmailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;



class AdminEmailController extends AbstractController
{
    #[Route('/admin/emails', name: 'app_admin_emails')]
    public function mails(ContactRepository $contactRepository): Response
    {
        $mails = $contactRepository->findBy([], ['date' => 'DESC']);
        return $this->render('admin/emails/mail.html.twig', [
            'emails' => $mails
        ]);
    }

    #[Route('/admin/emailSends', name: 'app_admin_emailSends')]
    public function sendsEmails(EmailsRepository $emailsRepository): Response
    {
        $mails = $emailsRepository->findBy([], ['date' => 'DESC']);
        return $this->render('admin/emails/mailSends.html.twig', [
            'emails' => $mails
        ]);
    }

    #[Route('/admin/delete_mail/{id}', name: 'app_admin_delete_mail')]
    public function removeMail(EntityManagerInterface $manager, Contact $contact): Response
    {
        $manager->remove($contact);
        $manager->flush();
        return $this->redirectToRoute('app_admin_emails');
    }

    #[Route('/admin/delete_mailSend/{id}', name: 'app_admin_delete_mailSend')]
    public function removeSendMail(EntityManagerInterface $manager, Emails $emails): Response
    {
        $manager->remove($emails);
        $manager->flush();
        return $this->redirectToRoute('app_admin_emailSends');
    }

    #[Route('/admin/mail', name:'app_admin_write_email')]
    public function sendMail(EntityManagerInterface $manager, Request $request, MailerInterface $mailer)
    {
        $user = $this->getUser();
        $mail = new Emails();
        $form = $this->createForm(AdminEmailFormType::class, $mail);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $mail->setEmail($form->get('email')->getData());
            $mail->setUser($user->getFirstName() . ' ' . $user->getLastName());
            $mail->setSubject($form->get('subject')->getData());
            $mail->setMessage($form->get('message')->getData());
            $mail->setDate(new \DateTimeImmutable());
            $manager->persist($mail);
            $manager->flush();
            $mail = new TemplatedEmail();
            $mail->from('contact@petittheatredelaruelle.be');
            $mail->to($form->get('email')->getData());
            $mail->subject($form->get('subject')->getData());
            $mail->htmlTemplate('admin/emails/templates/baseMail.html.twig')
                ->context(
                    [
                        'user' => $user->getFirstName() . ' ' . $user->getLastName(),
                        'subject' => $form->get('subject')->getData(),
                        'message' => $form->get('message')->getData(),
                    ]
                );

            $mailer->send($mail);
            $this->addFlash(
                'success',
                'E-mail envoyé avec succès!'
            );
            return $this->redirectToRoute('app_admin_emailSends', [
            ]);
        }
        return $this->renderForm('admin/emails/newEmail.html.twig', [
            'form' => $form,
        ]);
    }
}