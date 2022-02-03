<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Header;
use App\Entity\Genre;
use App\Entity\Produit;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EasyAdmin');
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Produit', 'fas fa-book-open', Produit::class);
        yield MenuItem::linkToCrud('Commande', 'fas fa-shopping-cart', Commande::class);
        yield MenuItem::linkToCrud('Categorie', 'fas fa-folder-open', Categorie::class);
        yield MenuItem::linkToCrud('Genre', 'fas fa-list-ul', Genre::class);
        yield MenuItem::linkToCrud('Header', 'fas fa-desktop', Header::class);
        
    }
}


