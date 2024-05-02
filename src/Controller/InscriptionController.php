<?php

namespace App\Controller;

use App\Form\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(Inscription::class);

        return $this->render('connexion/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}