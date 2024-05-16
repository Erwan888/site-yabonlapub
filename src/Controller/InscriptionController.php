<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function contact(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        /*$form = $this->createForm(Inscription::class);

        return $this->render('connexion/inscription.html.twig', [
            'form' => $form->createView(),
        ]);*/

        ////
        $user = new User();

        $form = $this->createForm(Inscription::class, $user);
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
            'form' => $form,
            'error' => $error
        ]);
    }
}