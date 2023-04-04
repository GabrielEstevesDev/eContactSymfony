<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Form\FormUtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
class UtilisateurController extends AbstractController
{
      
    #[Route('/accueil', name: 'uAccueil')]
    function accueil(EntityManagerInterface $entityManager, Request $request){
        $session = $request->getSession();
        
        if (is_null($session->get("pseudo"))) {
                return new RedirectResponse($this->generateUrl('sConnexion'));
         }
       
        $tab=array();
        $utilisateur=$entityManager->getRepository(Utilisateur::class)->findOneBy(['nom'=>$session->get("pseudo")]);
        $idNom = $utilisateur->getIdNom();
      
        $query=$entityManager->getRepository(Contact::class)->findBy(['id_nom'=>$idNom]);
        foreach($query as $value){
            $contact=$entityManager->getRepository(Utilisateur::class)->findBy(['id_nom'=>$value->getIdContact()]);
            array_push($tab,$contact);
        }
        
        
        return $this->render('utilisateur/accueil.html.twig',[
            'liste'=>$tab
        ]);	
    
    }

}