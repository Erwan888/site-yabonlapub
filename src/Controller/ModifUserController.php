<?php

namespace App\Controller;

use App\Entity\Association;
use App\Entity\Mecene;
use App\Entity\User;
use App\Form\ModifAssoCoordType;
use App\Form\ModifUserCoordType;
use App\Form\ModifPasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ModifUserController extends AbstractController
{
    #[Route('/informations', name: 'app_modif_user')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('connexion');
        if ($user instanceof Association && !$user->precisions()) {
            return $this->redirectToRoute('suite_inscription_asso');
        }
        return $this->render('modif_user/index.html.twig', []);
    }

    #[Route('/informations/consulter', name: 'app_user_coord')]
    public function userCoord(): Response
    {
        if (!$this->getUser()) return $this->redirectToRoute('connexion');
        return $this->render('modif_user/userCoord.html.twig', []);
    }

    #[Route('/informations/modifier', name: 'app_modif_user_coord')]
    public function modifUserCoord(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('connexion');

        if ($user instanceof Association) {
            $form = $this->createForm(ModifAssoCoordType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setLogin($form->get('login')->getData());
                $user->setEmail($form->get('email')->getData());

                $form->get('name')->getData()        ? $user->setName($form->get('name')->getData())              : '';
                $form->get('description')->getData() ? $user->setDescription($form->get('description')->getData()): '';
                $form->get('adress')->getData()      ? $user->setAdress($form->get('adress')->getData())          : '';
                $form->get('postal_code')->getData() ? $user->setPostalCode($form->get('postal_code')->getData()) : '';
                $form->get('city')->getData()        ? $user->setCity($form->get('city')->getData())              : '';
                $form->get('country')->getData()     ? $user->setCountry($form->get('country')->getData())        : '';
                $form->get('phone')->getData()       ? $user->setPhone($form->get('phone')->getData())            : '';
                $form->get('url_website')->getData() ? $user->setUrlWebsite($form->get('url_website')->getData()) : '';

                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_modif_user');
            }
        }

        if ($user instanceof User) {
            $form = $this->createForm(ModifUserCoordType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setLogin($form->get('login')->getData());
                $user->setEmail($form->get('email')->getData());

                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_modif_user');
            }
        }

        if ($user instanceof Mecene) {
            $form = $this->createForm(ModifUserCoordType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setLogin($form->get('login')->getData());
                $user->setEmail($form->get('email')->getData());

                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_modif_user');
            }
        }

        return $this->render('modif_user/edit.html.twig', [
            'modifUserCoordForm' => $form
        ]);
    }

    #[Route('/informations/modifier/motdepasse', name: 'app_modif_user_mdp')]
    public function modifUserMdp(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('connexion');
        $form = $this->createForm(ModifPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();
            
            if (!$userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
                return $this->render('modif_user/edit_password.html.twig', [
                    'modifPasswordForm' => $form
                ]);
            }
            
            if ($newPassword !== $confirmPassword) {
                $form->addError(new FormError('Les nouveaux mots de passe ne correspondent pas'));
                return $this->render('modif_user/edit_password.html.twig', [
                    'modifPasswordForm' => $form
                ]);
            }

            $mdp = $userPasswordHasher->hashPassword($user, $form->get('newPassword')->getData());
            $user->setPassword($mdp);
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_modif_user');
        }
        return $this->render('modif_user/edit_password.html.twig', [
            'modifPasswordForm' => $form
        ]);
    }

    #[Route('/informations/supprimer', name: 'app_delete_user')]
    public function deleteUser(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('connexion');

        $entityManager->remove($user);
        $entityManager->flush();

        $this->container->get('security.token_storage')->setToken(null);
                
        return $this->redirectToRoute('app_accueil');
    }
}
