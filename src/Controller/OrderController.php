<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\User;
use App\Form\OrderType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Classe\Mail;
use DateTimeImmutable;

class OrderController extends AbstractController
{
    private $entityManager;
    private $cart;

    public function __construct(EntityManagerInterface $entityManager, Cart $cart)
    {
        $this->entityManager = $entityManager;
        $this->cart = $cart;
    }

    #[Route('/commande', name: 'order')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        // Vous pouvez vérifier si l'utilisateur a des adresses, si non, redirigez-le vers la page d'ajout d'adresse.
        if (!$user->getAddresses()->isEmpty()) {
            $form = $this->createForm(OrderType::class, null, [
                'user' => $user
            ]);

            return $this->render('order/index.html.twig', [
                'form' => $form->createView(),
                'cart' => $this->cart->getFull()
            ]);
        } else {
            // Rediriger l'utilisateur vers la page d'ajout d'adresse s'il n'a pas encore d'adresse.
            return $this->redirectToRoute('address_add');
        }
    }

    #[Route('/commande/recapitulatif', name: 'order_recap', methods: ["POST"])]
    public function add(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstName().' '.$delivery->getLastName();
        
            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>' .$delivery->getPhone();
            }

            $delivery_content .= '<br/>' . $delivery->getAddress();
            $delivery_content .= '<br/>' . $delivery->getPostal() . ' ' . $delivery->getCity();
            $delivery_content .= '<br/>' . $delivery->getCountry();

            $order = new Order();
            $reference = $date->format('dmy').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setState(0);

            $this->entityManager->persist($order);
            
            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $order->addOrderDetail($orderDetails);
                $this->entityManager->persist($orderDetails);
            }
            
            $this->entityManager->flush();
            Stripe::setApiKey('sk_test_51NaaYrDVs5OvJZvbIU1bfYshFOVCzjIGDFhfYnfh6Zm6rM4XpAQXwjap6b2krBdY3t94R5s6MxrzcYe6ViywwFHL00YsbnDIxE');


            $mail = new Mail();
            $content = "Bonjour, " . $order->getUser()->getUserIdentifier() . ", bienvenue dans notre boutique en ligne";
            $mail->send($this->getUser()->getEmail(), $this->getUser(), 'Votre commande a bien été prise en compte', $content);

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery' => $delivery_content,
                'reference' => $order->getReference()
            ]);
        }

        return $this->redirectToRoute('cart');
    }
}
