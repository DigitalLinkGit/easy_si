<?php

namespace App\Capture\DataFixtures;

use App\Capture\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Organisation et Gouvernance' => 'Structure des responsabilités, comités, arbitrage, pilotage.',
            'Fonctionnalité et Usage' => 'Fonctions clés, besoins utilisateurs, scénarios typiques.',
            'Données et Volume' => 'Typologie de données, volumétrie, stockage, accès.',
            'Sécurité et Conformité' => 'Confidentialité, RGPD, accès, sauvegardes.',
            'Technique et Infrastructure' => 'Hébergement, performance, technologies employées.',
            'Interopérabilité et Interfaces' => 'API, connecteurs, compatibilité avec d’autres systèmes.',
            'Budget et Coûts' => 'Licences, frais récurrents, coûts projet.',
            'Planning et Périmètre' => 'Calendrier, livrables, jalons, limitations connues.',
        ];

        $index = 0;
        foreach ($categories as $name => $description) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);
            $manager->persist($category);

            // 🔁 Enregistrement de la référence pour QuestionFixtures
            $this->addReference('category_' . $index, $category);
            $index++;
        }

        $manager->flush();
    }
}
