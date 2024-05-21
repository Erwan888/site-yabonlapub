<?php

namespace App\Controller;

use App\Form\Connexion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'connexion')]
    public function contact(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error)
            $error = 'Login ou mot de passe incorrect, veuillez réessayer';

        return $this->render('connexion/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/statut', name: 'connexion_statement')]
    public function statement(): Response
    {
        if ($this->getUser())
            return $this->render('connexion/deconnexion.html.twig', []);
        else return $this->redirectToRoute('connexion');
    }
}
