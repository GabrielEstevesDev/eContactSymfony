<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    function liste_contacts() {
        $idnom =$_SESSION['profil']['id_nom'];
        require("./modele/contactBD.php");
        $resultat = readContact($idnom);
        return $this->render('./vue/contact/list_c.html.twig');
    }
}
?>