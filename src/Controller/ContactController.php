<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
//use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

        #[Route('/contact/liste/{idNom}', name: 'listeContact')]
        public function listeContact(ContactService $contactService,$idNom): Response
    {
        $allContacts = $contactService->getAllContacts($idNom);
        var_dump($allContacts);
        
        return $this->render('/contact/list_c.html.twig', ['liste' => $allContacts]);
    }
}
