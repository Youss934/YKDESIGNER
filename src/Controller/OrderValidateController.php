<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;

class OrderValidateController extends AbstractController
{ private $entityManager;
    public function __construct(Cart $cart,EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->Cart = $cart;
    }
    #[Route('/order_validate/merci/(stripeSessionId)', name: 'order_validate')]
    public function index($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        if(!$order || $order->getUser() != $this->getUser()){
            $this->redirectToRoute('home');
        }
        if($order->getState()==0 ) {
            $cart->remove();
            $order->setSt(1);
            $this->entityManager->flush();
        }
        
        
        return $this->render('order_validate/index.html.twig', [
            'order' => $order
        ]);
    }
}
