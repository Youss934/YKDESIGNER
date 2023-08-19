<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType; // Ajout de l'import pour le formulaire SearchType

class ProductController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'products')]
    public function index(Request $request): Response
    {
        $search = new Search(); 
        $form = $this->createForm(SearchType::class, $search); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) { 
            $products = $this->entityManager->getRepository(Produits::class)->findWithSearch($search);


            // $search = $form->getData(); 
        } else {
        $products = $this->entityManager->getRepository(Produits::class)->findAll();

        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug)
    {
        $product = $this->entityManager->getRepository(Produits::class)->findOneBySlug( $slug);
       $products = $this->entityManager->getRepository(Produits::class)->findByIsBest(1);
        if (!$product) {
            return $this->redirectToRoute('products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $products
        ]);
    }
}
