<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Classe\SearchNav;
use App\Form\CommandType;
use App\Form\SearchNavType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    private $entityManager;
    private $date;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->date = new \DateTime('now');
    }

    /**
     * @Route("/commande", name="commande")
     */
    public function index(Request $request, Cart $cart): Response
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
            $commande = new Commande();
            $total = 0;
            for ($i = 0; $i < count($cart->getFull()); $i++) {
                $total = $cart->getFull()[$i]['produit']->getPrix() * $cart->getFull()[0]['quantity'];
            }
            $user = $this->getUser();
            $formulaire = $this->createForm(CommandType::class, $commande);
            $formulaire->handleRequest($request);

            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $commande = $formulaire->getData();
                $commande->setTotal($total);
                $commande->setEtat('commande enregistrer');
                $commande->setDate($this->date);
                $commande->setUser($user);
                $commande->setAdresse($user->getAdresse());
                $this->entityManager->persist($commande);
                $this->entityManager->flush();
                $cart->remove();
                return $this->redirectToRoute('mon_compte');
            }

            return $this->render('commande/index.html.twig', [
                'cart' => $cart->getFull(),
                'form' => $formulaire->createView(),
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
