<?php

namespace App\Controller;

use App\Classe\Search;
use App\Classe\SearchNav;
use App\Entity\Produit;
use App\Form\SearchNavType;
use App\Form\SearchType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $ProduitRepository,  Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
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
            $search = new Search();
            $form = $this->createForm(SearchType::class, $search);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $paginator = $ProduitRepository->getProduitPaginator($offset, $search);
            } else {
                $paginator = $ProduitRepository->getAllProduitPaginator($offset);
            }

            return $this->render('produit/index.html.twig', [
                'produits' => $paginator,
                'form_nav' => $formNav->createView(),
                'form_search' => $form->createView(),
                'previous' => $offset - ProduitRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + ProduitRepository::PAGINATOR_PER_PAGE),
                ]);
        }
    }

    /**
     * @Route("/produits/{id}", name="products")
     */
    public function show($id, Request $request): Response
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
            $produit = $this->entityManager->getRepository(Produit::class)->findOneBy(['id' => $id]);

            if (!$produit) {
                return $this->redirectToRoute('produit');
            }
            return $this->render('produit/show.html.twig', [
                'produit' => $produit,
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
