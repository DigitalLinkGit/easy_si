<?php

namespace App\Global\DataFixtures;

use App\Global\Entity\ParticipantRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $role = new ParticipantRole();
        $role->setName("Sponsor");
        $role->setDescription("Responsable de l’initiative au niveau direction, valide les budgets et arbitrages stratégiques.");
        $manager->persist($role);

        $role = new ParticipantRole();
        $role->setName("Responsable métier");
        $role->setDescription("Représente les utilisateurs finaux, porte les besoins fonctionnels.");
        $manager->persist($role);

        $role = new ParticipantRole();
        $role->setName("Responsable technique");
        $role->setDescription("Garant des contraintes techniques internes (infrastructure, sécurité, compatibilité SI).");
        $manager->persist($role);

        $role = new ParticipantRole();
        $role->setName("Chef de projet");
        $role->setDescription("Coordonne les acteurs internes côté client, suit le planning et les livrables.");
        $manager->persist($role);

        $role = new ParticipantRole();
        $role->setName("Chef de projet");
        $role->setDescription("Pilote la réalisation du projet, point de contact principal côté prestataire.");
        $role->setIsInternal(true);
        $manager->persist($role);

        $role = new ParticipantRole();
        $role->setName("Consultant fonctionnel");
        $role->setDescription("Analyse les besoins, configure la solution, forme les utilisateurs.");
        $role->setIsInternal(true);
        $manager->persist($role);

        $role = new ParticipantRole();
        $role->setName("Développeur");
        $role->setDescription("Implémente les spécificités techniques, interfaces ou personnalisations.");
        $role->setIsInternal(true);
        $manager->persist($role);

        $role = new ParticipantRole();
        $role->setName("Architecte");
        $role->setDescription("Définit l’architecture technique cible et les échanges entre composants.");
        $role->setIsInternal(true);
        $manager->persist($role);

        $manager->flush();
    }
}
