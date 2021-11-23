<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HelloController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('base.html.twig', [
            'last_username' => $lastUsername, 
        ]);
    }
}
