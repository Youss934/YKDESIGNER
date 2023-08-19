<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Header;
use App\Entity\Order;
use App\Entity\Produits;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 1. Vous pouvez commenter cette partie si vous souhaitez afficher le tableau de bord EasyAdmin par défaut.
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. Vous pouvez commenter cette partie si vous ne souhaitez pas de redirection conditionnelle.
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. Vous pouvez commenter cette partie si vous ne souhaitez pas de rendu de modèle personnalisé.
        return $this->render('admin/index.html.twig');
        
        // Notez que si vous utilisez l'une des options ci-dessus, assurez-vous qu'une seule option est active à la fois.
        // Actuellement, l'option 3 est activée, ce qui signifie que le reste du code ne sera jamais exécuté.
        
        // return parent::index(); // Retourner la réponse du tableau de bord par défaut d'EasyAdmin
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('YK DESIGN');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Orders', 'fa fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Category', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fa fa-tag', Produits::class);
        yield MenuItem::linkToCrud('Carriers', 'fa fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Headers', 'fa fa-desktop', Header::class);
    }
}
