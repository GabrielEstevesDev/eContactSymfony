<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FormUtilisateurType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;


class UtilisateurController extends AbstractController
{
    public static $res;
    public static $tab=array();
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/', name: 'ident')]

    public function ident(Request $request, EntityManagerInterface $entityManager){
        $utilisateur=new Utilisateur();
        $form = $this->createForm(FormUtilisateurType::class,$utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            self::$res = $entityManager->getRepository(Utilisateur::class)->findOneBy([
                'nom' => $form["nom"]->getData(),
                'num' => $form["num"]->getData()
            ]);
            //var_dump($res);

            if(self::$res==NULL){
                $msg="Le compte n'existe pas";
                return $this->render('utilisateur/index.html.twig',[
                    'formconnexion'=>$form->createView(),
                    'msg'=>$msg
                ]);
            }
            else{
                $query=$entityManager->getRepository(Contact::class)->findBy(['id_nom'=>self::$res->getIdNom()]);
                // $tab=array();
                //var_dump($query);
                foreach($query as $value){
                    $contact=$entityManager->getRepository(Utilisateur::class)->findBy(['id_nom'=>$value->getIdContact()]);
                    array_push(self::$tab,$contact);
                }
                //var_dump($tab);
                return $this->render('utilisateur/accueil.html.twig',[
                    'nom'=>self::$res->getNom(),
                    'liste'=>self::$tab
                ]); 
            }
        }


        return $this->render('utilisateur/index.html.twig',[
            'formconnexion'=>$form->createView()
        ]);


    }

    #[Route('/accueil', name: 'home')]
    public function accueil(){
        return $this->render('utilisateur/accueil.html.twig',[
            'nom'=>self::$res->getNom(),
            'liste'=>self::$tab
        ]); 
    }
}
?>
