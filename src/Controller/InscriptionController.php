<?php

namespace App\Controller;

use App\Entity\User;
use App\Classe\SearchNav;
use App\Form\SearchNavType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encript): Response
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
            $user = new User();
            $formulaire = $this->createForm(InscriptionType::class, $user);
            $formulaire->handleRequest($request);
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $user = $formulaire->getData();

                $password = $encript->encodePassword($user, $user->getPassword());

                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_login');
            }
            return $this->render('inscription/index.html.twig', [
                'form' => $formulaire->createView(),
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
