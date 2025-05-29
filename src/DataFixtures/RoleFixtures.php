<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $role = new Role();
        $role->setName("Sponsor");
        $role->setDescription("Responsable de l’initiative au niveau direction, valide les budgets et arbitrages stratégiques.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Responsable métier");
        $role->setDescription("Représente les utilisateurs finaux, porte les besoins fonctionnels.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Responsable technique (client)");
        $role->setDescription("Garant des contraintes techniques internes (infrastructure, sécurité, compatibilité SI).");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Chef de projet (client)");
        $role->setDescription("Coordonne les acteurs internes côté client, suit le planning et les livrables.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Chef de projet (prestataire)");
        $role->setDescription("Pilote la réalisation du projet, point de contact principal côté prestataire.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Consultant fonctionnel");
        $role->setDescription("Analyse les besoins, configure la solution, forme les utilisateurs.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Développeur");
        $role->setDescription("Implémente les spécificités techniques, interfaces ou personnalisations.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Architecte SI");
        $role->setDescription("Définit l’architecture technique cible et les échanges entre composants.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Directeur de projet");
        $role->setDescription("Supervise le projet côté prestataire sur les aspects contractuels et stratégiques.");
        $manager->persist($role);

        $role = new Role();
        $role->setName("Administrateur système");
        $role->setDescription("Intervient sur le déploiement, les environnements techniques et la supervision.");
        $manager->persist($role);

        $manager->flush();
    }
}
