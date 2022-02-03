<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Classe\SearchNav;
use App\Form\SearchNavType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
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

            if ($this->getUser()) {
                return $this->redirectToRoute('home');
            }

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
                'form_nav' => $formNav->createView(),
            ]);
        }
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
