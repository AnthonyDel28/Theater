<?php

namespace App\Controller;

use App\Entity\Spectacles;
use App\Entity\Tickets;
use App\Repository\SpectaclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use DateTimeImmutable;
use Faker\Core\DateTime;
use Twig\Environment;
use Faker;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function carte(SessionInterface $session, SpectaclesRepository $spectaclesRepository): Response
    {
        $cart = $session->get("cart", []);
        $data = [];
        $total_price = 0;
        foreach($cart as $id => $amount){
            $spectacle = $spectaclesRepository->find($id);
            $data[] = [
                "spectacle" => $spectacle,
                "amount" => $amount
            ];
            $total_price += 18 * $amount;
        }
        return $this->render('cart/index.html.twig', [
            'data' => $data,
            'total' => $total_price,
        ]);
    }

    #[Route('/buyTicket/{id}', name: 'app_buy_ticket')]
    public function buyTicket(Spectacles $spectacles, SessionInterface $session)
    {
        $cart = $session->get("cart", []);
        $id = $spectacles->getId();

        if(!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set("cart", $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/removeTicket/{id}', name: 'app_remove_ticket')]
    public function removeTicket(Spectacles $spectacles, SessionInterface $session)
    {
        $cart = $session->get("cart", []);
        $id = $spectacles->getId();

        if(!empty($cart[$id])){
            if($cart[$id] > 1){
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }

        }
        $session->set("cart", $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/deleteSpectacle/{id}', name: 'app_delete_spectacle')]
    public function deleteSpectacleTickets(Spectacles $spectacles, SessionInterface $session)
    {
        $cart = $session->get("cart", []);
        $id = $spectacles->getId();

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }
        $session->set("cart", $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/deleteCart', name: 'app_delete_cart')]
    public function deleteCart(SessionInterface $session)
    {
        $session->remove("cart");

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/buyCart', name: 'app_buy_cart')]
    public function buyTickets(SessionInterface $session, EntityManagerInterface $manager, Request $request,
                               KernelInterface $kernel)
    {
        $user = $this->getUser();
        $faker = Faker\Factory::create();
        $cart = $session->get("cart", []);
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled',true);
        $dompdf = new Dompdf($pdfOptions);
        $countCart = count($cart);
        if($this->getUser()){
                foreach($cart as $id => $amount) {
                    $spectacle = $manager->getRepository(Spectacles::class)->find($id);
                    $ticket = new Tickets();
                    $ticket->setPrice(18 * $amount);
                    $ticket->setSpectacle($spectacle);
                    $ticket->setPersons($amount);
                    $ticket->setUser($this->getUser());
                    $ticket->setPurchasedAt(new \DateTimeImmutable());
                    $html = $this->renderView('tickets/ticket' . $ticket->getId() . '.html.twig', [
                        'spectacle' => $ticket->getSpectacle()->getTitre(),
                        'img' => $ticket->getSpectacle()->getImageName(),
                        'user' => $ticket->getUser()->getFirstName() . ' ' . $ticket->getUser()->getLastName(),
                        'date' => $ticket->getSpectacle()->getPeriod(),
                        'persons' => $amount,
                        'price' => $ticket->getPrice(),
                        'code' => $faker->randomNumber(7, false),
                    ]);

                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    $output = $dompdf->output();

                    $publicDirectory = $kernel->getProjectDir() . '/public/tickets';
                    $filename = 'ticket' . $ticket->getUser()->getId() . '_' . $faker->randomNumber(7, false) . '.pdf';
                    $pdfFilepath = $publicDirectory . '/' . $filename;
                    $ticket->setFile($filename);
                    file_put_contents($pdfFilepath, $output);
                    $manager->persist($ticket);
                    $manager->flush();
                    $session->remove("cart");
                }
        } else {
            $session->set("not_logged", TRUE);
            $this->addFlash(
                'warning',
                'Vous devez être connecté pour acheter des tickets!'
            );
            return $this->redirectToRoute('app_login');
        }
        $this->addFlash(
            'success',
            'Billets achetés avec succès, rendez-vous dans votre page de profil pour les télécharger!',
        );
        return $this->redirectToRoute('home');
    }
}
