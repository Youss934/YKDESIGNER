<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SymfonyConsoleMakeEntityController extends AbstractController
{
    #[Route('/symfony/console/make/entity', name: 'app_symfony_console_make_entity')]
    public function index(): Response
    {
        return $this->render('symfony_console_make_entity/index.html.twig', [
            'controller_name' => 'SymfonyConsoleMakeEntityController',
        ]);
    }
}
