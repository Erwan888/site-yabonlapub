<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'connexion')]
    public function connexion(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if ($user) return $this->redirectToRoute('connexion_statement');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error)
            $error = 'Login ou mot de passe incorrect, veuillez réessayer';

        // Render the page
    $response = $this->render('connexion/connexion.html.twig', ['last_username' => $lastUsername, 'error' => $error]);



    return $response;
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/statut', name: 'connexion_statement')]
    public function statementUser(): Response
    {
        $user = $this->getUser();
        $typeCompte = "";
        if ($user) {
            if ($user instanceof \App\Entity\User) $typeCompte = "particulier";
            elseif ($user instanceof \App\Entity\Association) $typeCompte = "association";
            else $typeCompte = "mécène";
        }
        if ($this->getUser())
            return $this->render('connexion/deconnexion.html.twig', [
                'typeCompte' => $typeCompte
            ]);
        else return $this->redirectToRoute('connexion');
    }
}
