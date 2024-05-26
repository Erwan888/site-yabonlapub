<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Mecene;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\AssociationPrecisionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\FormError;


class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription(): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        return $this->render('connexion/menu_inscription.html.twig', []);
    }

    #[Route('/inscription/particulier', name: 'inscription_user')]
    public function inscriptionUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setLogin($form->get('login')->getData());
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('connexion');
            }

            $form->get('plainPassword')->addError(new FormError('Les mots de passe sont différents.'));
        }

        return $this->render('connexion/inscription.html.twig', [
            'typeCompte' => "Particulier",
            'form' => $form
        ]);
    }

    #[Route('/inscription/association', name: 'inscription_asso')]
    public function inscriptionAsso(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        $user = new Association();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setLogin($form->get('login')->getData());
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('connexion');
            }

            $form->get('plainPassword')->addError(new FormError('Les mots de passe sont différents.'));
        }

        return $this->render('connexion/inscription.html.twig', [
            'typeCompte' => "Association",
            'form' => $form
        ]);
    }

    #[Route('/inscription/mecene', name: 'inscription_mecene')]
    public function inscriptionMecene(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        $user = new Mecene();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setLogin($form->get('login')->getData());
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('connexion');
            }

            $form->get('plainPassword')->addError(new FormError('Les mots de passe sont différents.'));
        }

        return $this->render('connexion/inscription.html.twig', [
            'typeCompte' => "Mécène",
            'form' => $form
        ]);
    }

    #[Route('/inscription/association/precisions', name: 'suite_inscription_asso')]
    public function suiteInscriptionAsso(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user || !$user instanceof Association) return $this->redirectToRoute('connexion');

        $form = $this->createForm(AssociationPrecisionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('name')->getData()? $user->setName($form->get('name')->getData()) : '';
            $form->get('description')->getData() ? $user->setDescription($form->get('description')->getData()) : '';
            $form->get('adress')->getData() ? $user->setAdress($form->get('adress')->getData()) : '';
            $form->get('postal_code')->getData() ? $user->setPostalCode($form->get('postal_code')->getData()) : '';
            $form->get('city')->getData() ? $user->setCity($form->get('city')->getData()) : '';
            $form->get('country')->getData() ? $user->setCountry($form->get('country')->getData()) : '';
            $form->get('phone')->getData() ? $user->setPhone($form->get('phone')->getData()) : '';
            $form->get('url_website')->getData() ? $user->setUrlWebsite($form->get('url_website')->getData()) : '';

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_coord');
        }

        return $this->render('connexion/asso_precision.html.twig', [
            'form' => $form
        ]);
    }
}