<?php


// src/Controller/AssociationInfoController.php

namespace App\Controller;

use App\Entity\Association;
use App\Form\AssociationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationInfoController extends AbstractController
{
    #[Route('/association/creation', name: 'association_info')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité Association
        $association = new Association();

        // Création du formulaire associé à l'entité Association
        $form = $this->createForm(AssociationType::class, $association);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            // Persistez l'entité dans la base de données
            $entityManager->persist($association);

            // Flush pour enregistrer les changements dans la base de données
            $entityManager->flush();

            // Redirection vers une autre page après le succès de la soumission du formulaire
            return $this->redirectToRoute('app_accueil');
        }

        // Affichage de la page avec le formulaire
        return $this->render('association_info/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

