<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UtilisateurController extends AbstractController
{
   
    #[Route('/ident', name: 'app_ident')]
    public function ident(){
        $nom=  isset($_POST['nom'])?($_POST['nom']):'';
        $num=  isset($_POST['num'])?($_POST['num']):'';
        $msg='';

        if  (count($_POST)==0)
            return $this->render('utilisateur/ident.html.twig');
        else {
           
            require("../src/Entity/UtilisateurBD.php");
            if  (! verif_ident()) {
                $_SESSION['profil']= array();
                
                $msg ="erreur de saisie";
                return $this->render('utilisateur/ident.html.twig');
            }
            else { 
                $response = new RedirectResponse('/accueil');
                $response->send();
                // return new RedirectResponse($this->urlGenerator->generate('app_accueil'));
                //echo ("ok, bienvenue"); 
            }
        }	
        }
        #[Route('/accueil', name: 'app_accueil')]
        function accueil(){
            $nom = $_SESSION['profil']['nom'];
            $idu = $_SESSION['profil']['id_nom'];
            // $resultat = $_SESSION['resultat'];
        
            require("../src/Entity/contactBD.php");
            $L = readContact($idu);
            return $this->render ("utilisateur/accueil.html.twig",
            [
                'nom' => $nom,
                'liste' => $L,
            ]);
           
        }

}
?>
