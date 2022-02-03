<?php

namespace App\Twig;

use App\Classe\Cart;
use App\Classe\Navbar;
use App\Classe\SearchNav;
use App\Entity\Categorie;
use App\Entity\Genre;
use App\Form\SearchNavType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Test\FormInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;

class AppExtension extends AbstractExtension
{
    private $entityManager;
    private $panier;
    private $ma_recherche;
    public function __construct(EntityManagerInterface $entityManager, Cart $cart, Navbar $ma_recherche)
    {
        $this->entityManager = $entityManager;
        $this->panier = $cart;
        $this->ma_recherche = $ma_recherche;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('ItemMenu', [$this, 'ItemMenu']),
            new TwigFunction('PanierItem', [$this, 'PanierItem']),
            new TwigFunction('Nav', [$this, 'Nav']),
        ];
    }

    public function ItemMenu($entity)
    {
        if ($entity == 'category') {
            $categorie = $this->entityManager->getRepository(Categorie::class)->findAll();
            return $categorie;
        } elseif ($entity == 'genre') {
            $genre = $this->entityManager->getRepository(Genre::class)->findAll();
            return $genre;
        }
    }

    public function PanierItem()
    {
        return $this->panier->getFull();
    }

    public function Nav()
    {
        return $this->ma_recherche->Recherche();
    }
}
