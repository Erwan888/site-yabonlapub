<?php

namespace App\Controller;

use App\Form\Connexion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'connexion')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(Connexion::class);

        return $this->render('connexion/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
