<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Classe\SearchNav;
use App\Form\SearchNavType;
use App\Form\EditeCompteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditCompteController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/edit-compte", name="edit_compte")
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
            $formulaire = $this->createForm(EditeCompteType::class, $user);
            $formulaire->handleRequest($request);
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $user = $formulaire->getData();
                //dd($user);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
            return $this->render('edit_compte/index.html.twig', [
                'form_nav' => $formNav->createView(),
                'form' => $formulaire->createView(),
            ]);
        }
    }
}
