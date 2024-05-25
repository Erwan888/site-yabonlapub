<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Mecene;
use App\Entity\User;
use App\Form\AssociationInscriptionType;
use App\Form\MeceneInscriptionType;
use App\Form\UserInscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class InscriptionController extends AbstractController
{
    #[Route('/inscription/particulier', name: 'inscription_user')]
    public function inscriptionUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        $user = new User();
        $form = $this->createForm(UserInscriptionType::class, $user);
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setLogin($form->get('login')->getData());
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setRoles(['ROLE_USER']);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('connexion');
            }

            $error = "Mots de passe différents";
        }

        return $this->render('connexion/inscription.html.twig', [
            'typeCompte' => "Particulier",
            'form' => $form,
            'error' => $error
        ]);
    }

    #[Route('/inscription/association', name: 'inscription_asso')]
    public function inscriptionAsso(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        $user = new Association();
        $form = $this->createForm(AssociationInscriptionType::class, $user);
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setLogin($form->get('login')->getData());
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setRoles(['ROLE_ASSO']);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('connexion');
            }

            $error = "Mots de passe différents";
        }

        return $this->render('connexion/inscription.html.twig', [
            'typeCompte' => "Association",
            'form' => $form,
            'error' => $error
        ]);
    }

    #[Route('/inscription/mecene', name: 'inscription_mecene')]
    public function inscriptionMecene(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        $user = new Mecene();
        $form = $this->createForm(MeceneInscriptionType::class, $user);
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                $user->setLogin($form->get('login')->getData());
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setRoles(['ROLE_MECENE']);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('connexion');
            }

            $error = "Mots de passe différents";
        }

        return $this->render('connexion/inscription.html.twig', [
            'typeCompte' => "Mécène",
            'form' => $form,
            'error' => $error
        ]);
    }
}