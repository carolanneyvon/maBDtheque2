<?php

namespace App\Controller;

use App\Classe\SearchNav;
use App\Entity\Produit;
use App\Form\SearchNavType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavBarController extends AbstractController
{
    public function searchNav(Request $request): Response
    {
        $searchNav = new SearchNav();
        $formNav = $this->createForm(SearchNavType::class, $searchNav);
        $formNav->handleRequest($request);

        if ($formNav->isSubmitted() && $formNav->isValid()) {
            $produits = $this->entityManager->getRepository(Produit::class)->findWithSearchNav($searchNav);

            return $this->render('produit/nav.html.twig', [
                'produits' => $produits,
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
