<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Classe\SearchNav;
use App\Form\SearchNavType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonCompteController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-compte", name="mon_compte")
     */
    public function index(Request $request): Response
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
        } else {
            $user = $this->getUser();
            $Commande = $this->entityManager->getRepository(Commande::class)->findByUser($user->getId());

            return $this->render('mon_compte/index.html.twig', [
                'command' => $Commande,
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
