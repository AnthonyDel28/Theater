<?php

namespace App\Controller;

use App\Entity\Spectacles;
use App\Entity\Tickets;
use App\Repository\SpectaclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
    public function buyTickets(SessionInterface $session, EntityManagerInterface $manager)
    {
        $cart = $session->get("cart", []);
        if($this->getUser()){
            foreach($cart as $id => $amount){
                $spectacle = $manager->getRepository(Spectacles::class)->find($id);
                $ticket = new Tickets();
                $ticket->setPrice(18);
                $ticket->setSpectacle($spectacle);
                $ticket->setUser($this->getUser());
                $ticket->setPurchasedAt(new \DateTimeImmutable());
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
        return $this->redirectToRoute('home');
    }
}
