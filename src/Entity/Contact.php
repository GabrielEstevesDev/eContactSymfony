<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_nom = null;

    #[ORM\Column]
    private ?int $id_contact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdNom(): ?int
    {
        return $this->id_nom;
    }

    public function setIdNom(int $id_nom): self
    {
        $this->id_nom = $id_nom;

        return $this;
    }

    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    public function setIdContact(int $id_contact): self
    {
        $this->id_contact = $id_contact;

        return $this;
    }

    public function getAllContacts(int $id): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $contacts = $entityManager->getRepository(Contact::class)->findBy(['id_nom' => $id]);

        $allContacts = [];
        foreach ($contacts as $contact) {
            $contactUser = $entityManager->getRepository(Utilisateur::class)->findOneBy(['id_nom' => $contact->getIdContact()]);
            if ($contactUser !== null) {
                $allContacts[] = $contactUser;
            }
        }

        return $allContacts;
    }

}
