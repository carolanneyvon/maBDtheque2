<?php

namespace App\Controller;


use App\Entity\Header;
use App\Entity\Produit;
use App\Classe\SearchNav;
use App\Form\SearchNavType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $produit = $this->entityManager->getRepository(Produit::class)->findBy(['isBest' => 1]);
        $produitConseil = $this->entityManager->getRepository(Produit::class)->findBy(['conseil' => 1]);
        $headers = $this->entityManager->getRepository(Header::class)->findAll();

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
            $produits = $this->entityManager->getRepository(Produit::class)->findAll();

            return $this->render('home/index.html.twig', [
                'produit' => $produit,
                'form_nav' => $formNav->createView(),
                'produitConseil' => $produitConseil,
                'headers' => $headers
            ]);
        }
    }

    /**
     * @Route("/notre-histoire", name="notre_histoire")
     */
    public function notrehistoire(Request $request): Response
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
            return $this->render('home/histoire.html.twig', [
                'form_nav' => $formNav->createView(),
            ]);
        }
    }

    /**
     * @Route("/confidentialite", name="confidentialite")
     */
    public function confidentialite(Request $request): Response
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
            return $this->render('home/confidentialite.html.twig', [
                'form_nav' => $formNav->createView(),
            ]);
        }
    }

    /**
     * @Route("/expedition", name="expedition")
     */
    public function expedition(Request $request): Response
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
            return $this->render('home/expedition.html.twig', [
                'form_nav' => $formNav->createView(),
            ]);
        }
    }

    /**
     * @Route("/cgv", name="cgv")
     */
    public function cgv(Request $request): Response
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
            return $this->render('home/cgv.html.twig', [
                'form_nav' => $formNav->createView(),
            ]);
        }
    }

    /**
     * @Route("/retour", name="retour")
     */
    public function retour(Request $request): Response
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
            return $this->render('home/retour.html.twig', [
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
