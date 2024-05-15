<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\AssociationType;
use App\Entity\Association;

class AssociationInfoController extends AbstractController
{
    #[Route('/association/info', name: 'association_info')]
    public function index(): Response
    {
        $asso= new Association(); 

        $form = $this->createForm(AssociationType::class, $asso);

        return $this->render('association_info/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
