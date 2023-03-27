<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/security/inscription', name: 'app_inscription')]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher)
    {
        $utilisateur = new Utilisateur();

        $form = $this->createForm(RegistrationType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $passwordHasher->hashPassword($utilisateur, $utilisateur->getNum());
            $utilisateur->setNum($hash);
            $manager->persist($utilisateur);
            $manager->flush();
            return new RedirectResponse($this->generateUrl('app_ident'));
        }

        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()]);
    }

    
}
