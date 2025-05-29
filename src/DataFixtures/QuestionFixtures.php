<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Category;
use App\Entity\Proposal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $questionsByCategory = [
            'Organisation et Gouvernance' => [
                ['name' => 'org_processus', 'content' => 'Les processus métier sont-ils clairement définis ?'],
                ['name' => 'org_responsables', 'content' => 'Y a-t-il des responsables clairement identifiés pour chaque domaine fonctionnel ?'],
                ['name' => 'org_comitologie', 'content' => 'Existe-t-il une comitologie de gouvernance ?'],
                ['name' => 'org_conduite_changement', 'content' => 'Comment la conduite du changement est-elle gérée ?'],
                ['name' => 'org_decision', 'content' => 'Comment sont prises les décisions dans le projet ?'],
            ],
            'Fonctionnalité et Usage' => [
                ['name' => 'func_principales', 'content' => 'Quelles sont les fonctionnalités principales attendues ?'],
                ['name' => 'func_priorisation', 'content' => 'Comment les besoins sont-ils priorisés ?'],
                ['name' => 'func_manuels', 'content' => 'Y a-t-il des processus encore manuels ?'],
                ['name' => 'func_usages', 'content' => 'Quels sont les usages actuels des utilisateurs ?'],
                ['name' => 'func_attentes', 'content' => 'Quelles sont les attentes utilisateurs non couvertes ?'],
            ],
            'Données et Volume' => [
                ['name' => 'data_types', 'content' => 'Quels types de données sont manipulées ?'],
                ['name' => 'data_volume', 'content' => 'Quel est le volume de données estimé ?'],
                ['name' => 'data_historique', 'content' => 'Des historiques doivent-ils être conservés ?'],
                ['name' => 'data_sources', 'content' => 'Quelles sont les sources des données ?'],
                ['name' => 'data_echange', 'content' => 'À quelle fréquence les données sont-elles échangées ?'],
            ],
            'Sécurité et Conformité' => [
                ['name' => 'sec_donnees', 'content' => 'Les données sont-elles sensibles ?'],
                ['name' => 'sec_rgpd', 'content' => 'Des obligations RGPD s’appliquent-elles ?'],
                ['name' => 'sec_acces', 'content' => 'Quels sont les niveaux d’accès nécessaires ?'],
                ['name' => 'sec_traces', 'content' => 'Des traces d’activité doivent-elles être conservées ?'],
                ['name' => 'sec_audits', 'content' => 'Le système doit-il être auditable ?'],
            ],
            'Technique et Infrastructure' => [
                ['name' => 'tech_hebergement', 'content' => 'Quel type d’hébergement est envisagé ?'],
                ['name' => 'tech_languages', 'content' => 'Quels langages / frameworks sont utilisés ?'],
                ['name' => 'tech_maintenance', 'content' => 'Comment est organisée la maintenance technique ?'],
                ['name' => 'tech_outils', 'content' => 'Quels outils techniques sont déjà en place ?'],
                ['name' => 'tech_sauvegarde', 'content' => 'Quelle est la stratégie de sauvegarde ?'],
            ],
            'Interopérabilité et Interfaces' => [
                ['name' => 'interop_api', 'content' => 'Y a-t-il des API à exposer ou consommer ?'],
                ['name' => 'interop_flux', 'content' => 'Quels flux de données sont à prévoir ?'],
                ['name' => 'interop_protocoles', 'content' => 'Quels protocoles sont utilisés ?'],
                ['name' => 'interop_format', 'content' => 'Quels formats de données sont attendus ?'],
                ['name' => 'interop_systemes', 'content' => 'Quels systèmes doivent interagir avec l’application ?'],
            ],
            'Budget et Coûts' => [
                ['name' => 'budget_estime', 'content' => 'Quel est le budget estimé pour le projet ?'],
                ['name' => 'budget_recurrent', 'content' => 'Y a-t-il des coûts récurrents associés ?'],
                ['name' => 'budget_sources', 'content' => 'Quelles sont les sources de financement ?'],
                ['name' => 'budget_priorite', 'content' => 'Quels postes de coûts sont prioritaires ?'],
                ['name' => 'budget_optimisation', 'content' => 'Des pistes d’optimisation budgétaire existent-elles ?'],
            ],
            'Planning et Périmètre' => [
                ['name' => 'plan_milestones', 'content' => 'Quelles sont les grandes étapes du projet ?'],
                ['name' => 'plan_livrables', 'content' => 'Quels sont les livrables attendus ?'],
                ['name' => 'plan_risques', 'content' => 'Quels sont les risques majeurs identifiés ?'],
                ['name' => 'plan_ressources', 'content' => 'Quelles ressources sont mobilisées ?'],
                ['name' => 'plan_echeances', 'content' => 'Quelles sont les échéances clés ?'],
            ],
        ];

        $i = 0;
        foreach ($questionsByCategory as $categoryLabel => $questions) {
            /** @var Category $category */
            $category = $this->getReference('category_' . $i,Category::class);

            foreach ($questions as $index => $data) {
                $question = new Question();
                $question->setName($data['name']);
                $question->setContent($data['content']);
                $question->setCategory($category);

                // Type
                if (in_array($index, [0, 3])) {
                    $question->setMultipleChoice(false); // Ouverte
                } elseif (in_array($index, [1, 4])) {
                    $question->setMultipleChoice(false); // Choix unique
                    foreach (['Oui', 'Non', 'Partiellement'] as $label) {
                        $proposal = new Proposal();
                        $proposal->setContent($label);
                        $proposal->setQuestion($question);
                        $manager->persist($proposal);
                    }
                } else {
                    $question->setMultipleChoice(true); // Choix multiple
                    foreach (['Option A', 'Option B', 'Option C'] as $label) {
                        $proposal = new Proposal();
                        $proposal->setContent($label);
                        $proposal->setQuestion($question);
                        $manager->persist($proposal);
                    }
                }

                $manager->persist($question);
            }

            $i++;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
