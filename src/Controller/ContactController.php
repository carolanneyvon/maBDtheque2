<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Classe\SearchNav;
use App\Form\ContactType;
use App\Form\SearchNavType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
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
            $message = null;
            $data = ['Field1' => null, 'Field2' => null];
            $formulaire = $this->createForm(ContactType::class, $data);
            $formulaire->handleRequest($request);
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $message = "Votre message à bien été envoyer ";
                //dd("Parfait");
            }
            return $this->render('contact/index.html.twig', [
                'form' => $formulaire->createView(),
                'message' => $message,
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
