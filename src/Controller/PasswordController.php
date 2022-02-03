<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Classe\SearchNav;
use App\Form\SearchNavType;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/password", name="password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $criptor): Response
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
            $formulaire = $this->createForm(ChangePasswordType::class, $user);

            $formulaire->handleRequest($request);

            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $ancien_password = $formulaire->get('ancien_password')->getData();

                if ($criptor->isPasswordValid($user, $ancien_password)) {
                    $nouveau_password = $formulaire->get('nouveau_password')->getdata();
                    $password = $criptor->encodePassword($user, $nouveau_password);
                    $user->setPassword($password);
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                    //dd("'Tout s'est bien passé ");
                }
            }

            return $this->render('password/index.html.twig', [
                'form' => $formulaire->createView(),
                'form_nav' => $formNav->createView(),
            ]);
        }
    }
}
