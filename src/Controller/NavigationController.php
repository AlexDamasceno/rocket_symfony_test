<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_ADMIN")
*/
class NavigationController extends AbstractController
{
        /**
         * @Route("/", name="home")
         */
        public function home()
        {
                return $this->render('navigation/home.html.twig');
        }

        /**
         * @Route("/membre", name="membre")
         */
        public function membre()
        {
            //test si un utilisateur est connecté
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            return $this->render('navigation/membre.html.twig');
        }

        /**
         * @Route("/admin", name="admin")
         */
        public function admin()
        {
            //récupération de l'utilisateur security>Bundle
            $utilisateur = $this->getUser();

            //vérification des droits.
            if($utilisateur && in_array('ROLE_ADMIN', $utilisateur->getRoles())){
                    return $this->render('navigation/admin.html.twig');
            }
    
            //redirection
            $session->set("message", "Vous n'avez pas le droit d'acceder à la page admin vous avez été redirigé sur cette page");
            return $this->redirectToRoute('home');
        }

}