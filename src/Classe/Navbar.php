<?php

namespace App\Classe;

use App\Classe\SearchNav;
use App\Entity\Produit;
use App\Form\SearchNavType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Navbar extends AbstractController
{
    private $entityManager;
    //private $request ;
    public function __construct(EntityManagerInterface $entityManager /*,Request $request*/)
    {
        $this->entityManager = $entityManager;
        //$this->request=$request;
    }

    public function Recherche()
    {
        $searchNav = new SearchNav();
        $formNav = $this->createForm(SearchNavType::class, $searchNav);
        return ['form_nav' => $formNav->createView()];
    }
}
