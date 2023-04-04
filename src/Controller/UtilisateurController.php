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
      
    // #[Route('/utilisateur/ident', name: 'app_ident')]
    // public function ident(EntityManagerInterface $entityManager, Request $request){
    //     $session = $request->getSession();
    //     // if ($session->has('nom')) {
    //     //     return new RedirectResponse($this->generateUrl('app_accueil'));
    //     // }
    //     $utilisateur = new Utilisateur();
    //     $tab= array();
    //     $form = $this->createFormBuilder($utilisateur)
    //             ->add('Nom', TextType::class)
    //             ->add("Num", TextType::class)
    //             ->add("Envoyer", SubmitType::class)
    //             ->getForm();
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){
    //         $repository = $entityManager->getRepository(Utilisateur::class);
    //         $utilisateur = $repository->findOneBy([
    //             'nom' => $form->get('Nom')->getData(),
    //             'num' => $form->get('Num')->getData(),
    //         ]);
    //         if($utilisateur){
    //             $query=$entityManager->getRepository(Contact::class)->findBy(['id_nom'=>$utilisateur->getIdNom()]);
    //             $session->set('nom', $utilisateur->getNom());
    //             foreach($query as $value){
    //                 $contact=$entityManager->getRepository(Utilisateur::class)->findBy(['id_nom'=>$value->getIdContact()]);
    //                 array_push($tab,$contact);
    //             }
    //             $session->set('liste', $tab);
    //             // $contact = new Contact();
    //             // $liste = $contact->getAllContacts($utilisateur->getIdNom());
               
    //             return new RedirectResponse($this->generateUrl('app_accueil'));
            
    //         }
    //         else{
    //             $msg = "Utilisateur inconnu !";
    //             return $this->render('utilisateur/ident.html.twig',[
    //                 'form' => $form->createView(),
    //                 'msg' => $msg
    //             ]);	
    //         }
    //     }
    //     return $this->render('utilisateur/ident.html.twig',[
    //         'form' => $form->createView()
    //     ]);	
        
    // }
    #[Route('/accueil', name: 'uAccueil')]
    function accueil(EntityManagerInterface $entityManager, Request $request){
        $session = $request->getSession();
        
        if (is_null($session->get("pseudo"))) {
                return new RedirectResponse($this->generateUrl('app_login'));
         }
         var_dump($session->get("pseudo"));
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