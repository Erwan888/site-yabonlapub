<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChoisirUnJeuController extends AbstractController
{
    #[Route('/choisirunjeu', name: 'choisirunjeu')]
    public function index(): Response
    {
        return $this->render('Jeu/choisirunjeu.html.twig', []);
    }
}
