<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use App\Entity\Utilisateur;

class ContactService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllContacts(int $id_nom): array
    {
        $contacts = $this->entityManager->getRepository(Contact::class)->findBy(['id_nom' => $id_nom]);

        $allContacts = array();
        foreach ($contacts as $contact) {
            $contactUser = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['id_nom' => $contact->getIdContact()]);
            $serializedContact = serialize($contactUser);
            array_push($allContacts,$serializedContact);
        }

        return $allContacts;
    }
}