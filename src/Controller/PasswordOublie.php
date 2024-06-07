<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Compte;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordOublie extends AbstractController
{

    #[Route('/choixReinitialisationDeMotDePasse', name: 'choixReinitialisation')]
    public function index(): Response
    {
        return $this->render('connexion/choix_reinitialisation_mdp.html.twig');
    }

    #[Route('/reset', name: 'motdepasseoublie')]
    public function Question(): Response
    {
        $question = "Quel est le nom de votre meilleur ami d'enfance ?";
        return $this->render('connexion/passwordOublie.html.twig',[
            'question' => $question,
        ]);
    }

    #[Route('/process-forgot-password', name: 'process_mdp', methods: ['POST'])]
public function processForgotPassword(Request $request, UserProviderInterface $userProvider, MailerInterface $mailer, SessionInterface $session): Response
{
    // Récupérer le temps d'attente depuis la session
    $tempsAttente = $session->get('temps_attente', 2); // Valeur par défaut de 2 secondes

    // Récupérer la réponse du formulaire
    $reponse = $request->request->get('reponse');

    // Vérifier si la réponse est "Geoffrey"
    if ($reponse === "Geoffrey") {
        // Générer un token factice pour la démonstration
        $token = 'dummy-token';

        // Réinitialiser le temps d'attente à 2 secondes
        $session->set('temps_attente', 2);

        // Rediriger vers la route 'reset_password' avec le token
        return $this->redirectToRoute('reset_password', ['token' => $token]);
    }

    // Si la réponse n'est pas "Geoffrey", ralentir la réponse de manière exponentielle
    sleep($tempsAttente); // Ralentir la réponse selon le temps d'attente actuel

    // Multiplier le temps d'attente par 2 à chaque réponse incorrecte
    $tempsAttente *= 2;

    // Stocker le nouveau temps d'attente dans la session
    $session->set('temps_attente', $tempsAttente);

    // Envoi d'une réponse HTTP 400 (Bad Request) avec un message d'erreur
    return new Response('La réponse fournie est incorrecte', 400);
}

    #[Route('/reset-password/{token}', name: 'reset_password')]
    public function resetPassword(Request $request, string $token,ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher, UserProviderInterface $userProvider,EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('mail');
            $newPassword = $request->request->get('new_password');

            // Trouver l'utilisateur par email
            $compte = $doctrine->getRepository(Compte::class)->findOneBy(['email' => $email]);


            if (!$compte) {
                return $this->render('connexion/reset_password.html.twig', [
                    'token' => $token,
                    'error' => 'Aucun compte trouvé pour cet email.',
                ]);
            }

             // Encoder le nouveau mot de passe
        $hashedPassword = $passwordHasher->hashPassword($compte, $newPassword);
        $compte->setPassword($hashedPassword);

        // Enregistrer les modifications
        $entityManager->persist($compte);
        $entityManager->flush();

        return $this->redirectToRoute('connexion', [
            'error' => null, // Passer l'erreur au template Twig
        ]);
        }

        return $this->render('connexion/reset_password.html.twig', [
            'token' => $token
        ]);
    }

    #[Route('/recupérationMail', name: 'mail')]
    public function forgotPassword(MailerInterface $mailer): Response
    {
        return $this->render('connexion/envoiemail.html.twig');
    }
    
    #[Route('/envoiemail', name: 'envoiemail', methods: ['POST'])]
    public function processForm(Request $request, MailerInterface $mailer): Response
    {
        // Get the email from the form
        $emailAddress = $request->request->get('email');

        
        if ($emailAddress) {
            $token = 'dummy-token';
            // Create the email
            $email = (new Email())
                ->from('noreply-YabonLaPub@gmail.com')
                ->to($emailAddress)
                ->subject('Récupération de mot de passe')
                ->text('Cliquez sur ce lien pour récupérer votre mot de passe : http://127.0.0.1:8000/reset-password/'.$token);

            // Send the email
            $mailer->send($email);

            // Add a flash message for success
            $this->addFlash('success', 'Email de récupération envoyé avec succès !');
        }

        // Redirect to the form page
        return $this->redirectToRoute('mail');
    }

    #[Route('/update-password/{token}', name: 'update_password', methods: ['POST'])]
    public function updatePassword(Request $request, string $token): Response
    {
        $newPassword = $request->request->get('password');
            $confirmPassword = $request->request->get('confirmationpassword');

            if ($newPassword !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return new Response('Les mots de passe ne correspondent pas', 400);
            }
        // Logique pour valider et mettre à jour le mot de passe...
        // Exemple : vérifier la validité du token, rechercher l'utilisateur, encoder le nouveau mot de passe et sauvegarder.

        // Rediriger vers la page de connexion après la mise à jour du mot de passe
        return $this->redirectToRoute('connexion');
    }

    
}
