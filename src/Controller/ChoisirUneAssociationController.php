<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChoisirUneAssociationController extends AbstractController
{
    #[Route('/choisiruneassociation', name: 'choisiruneassociation')]
    public function index(): Response
    {
        return $this->render('Association/choisiruneassociation.html.twig', []);
    }
}
