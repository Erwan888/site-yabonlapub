<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SpaceInvadersController extends AbstractController
{
    #[Route('/space/invaders', name: 'app_space_invaders')]
    public function index(): Response
    {
        return $this->render('space_invaders/index.html.twig', [
            'controller_name' => 'SpaceInvadersController',
        ]);
    }
}
