<?php

namespace App\Capture\DataFixtures;

use App\Capture\Entity\QuizCapture;
use App\Capture\Entity\Question;
use App\Capture\Entity\Proposal;
use App\Capture\Entity\QuestionInstance;
use App\Capture\Enum\AnswerType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuizFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $quiz0 = new QuizCapture();
        $quiz0->setName('Contexte métier');
        $quiz0->setDescription('Paix répéter vague.');
        $manager->persist($quiz0);

        $quiz1 = new QuizCapture();
        $quiz1->setName('Fonctionnalités souhaitées');
        $quiz1->setDescription('Voyage observer nerveux beaucoup appartenir.');
        $manager->persist($quiz1);

        $quiz2 = new QuizCapture();
        $quiz2->setName('Contraintes techniques');
        $quiz2->setDescription('Fermer former usage détruire toucher avec pourquoi.');
        $manager->persist($quiz2);

        $q1 = new Question();
        $q1->setName('Secteur d\'activité');
        $q1->setType(AnswerType::TEXT);
        $q1->setContent('Parcourir sein maître voler. Étage autour long présenter attendre ventre.');
        $manager->persist($q1);
        $instance1 = new QuestionInstance();
        $instance1->setQuestion($q1);
        $instance1->setQuiz($quiz0);
        $manager->persist($instance1);

        $q2 = new Question();
        $q2->setName('Nombre de commandes mensuelles');
        $q2->setType(AnswerType::NUMBER);
        $q2->setContent('Chasse prison condamner derrière chute certainement. Premier simple flamme craindre.');
        $manager->persist($q2);
        $instance2 = new QuestionInstance();
        $instance2->setQuestion($q2);
        $instance2->setQuiz($quiz0);
        $manager->persist($instance2);

        $q3 = new Question();
        $q3->setName('Canaux de vente utilisés');
        $q3->setType(AnswerType::MULTI_CHOICE);
        $q3->setContent('Semblable distance page parole tu trois race commun. Corps secret sou dernier avec. Vin douceur venir supérieur soulever.');
        $manager->persist($q3);
        $p3_0 = new Proposal();
        $p3_0->setContent('Site web');
        $p3_0->setQuestion($q3);
        $manager->persist($p3_0);
        $p3_1 = new Proposal();
        $p3_1->setContent('Boutique physique');
        $p3_1->setQuestion($q3);
        $manager->persist($p3_1);
        $p3_2 = new Proposal();
        $p3_2->setContent('Téléphone');
        $p3_2->setQuestion($q3);
        $manager->persist($p3_2);
        $p3_3 = new Proposal();
        $p3_3->setContent('Marketplace');
        $p3_3->setQuestion($q3);
        $manager->persist($p3_3);
        $instance3 = new QuestionInstance();
        $instance3->setQuestion($q3);
        $instance3->setQuiz($quiz0);
        $manager->persist($instance3);

        $q4 = new Question();
        $q4->setName('Fonctionnalités prioritaires');
        $q4->setType(AnswerType::MULTI_CHOICE);
        $q4->setContent('Devoir tâche groupe prêt. Tombe il possible. Depuis certain oiseau année étaler parent trente emporter.');
        $manager->persist($q4);
        $p4_0 = new Proposal();
        $p4_0->setContent('Gestion stock');
        $p4_0->setQuestion($q4);
        $manager->persist($p4_0);
        $p4_1 = new Proposal();
        $p4_1->setContent('Facturation');
        $p4_1->setQuestion($q4);
        $manager->persist($p4_1);
        $p4_2 = new Proposal();
        $p4_2->setContent('CRM');
        $p4_2->setQuestion($q4);
        $manager->persist($p4_2);
        $p4_3 = new Proposal();
        $p4_3->setContent('Reporting');
        $p4_3->setQuestion($q4);
        $manager->persist($p4_3);
        $instance4 = new QuestionInstance();
        $instance4->setQuestion($q4);
        $instance4->setQuiz($quiz1);
        $manager->persist($instance4);

        $q5 = new Question();
        $q5->setName('Intégration ERP');
        $q5->setType(AnswerType::SINGLE_CHOICE);
        $q5->setContent('Été quel anglais détruire parcourir demi élément chat. Voici sol amour visible sonner.');
        $manager->persist($q5);
        $p5_0 = new Proposal();
        $p5_0->setContent('Oui');
        $p5_0->setQuestion($q5);
        $manager->persist($p5_0);
        $p5_1 = new Proposal();
        $p5_1->setContent('Non');
        $p5_1->setQuestion($q5);
        $manager->persist($p5_1);
        $instance5 = new QuestionInstance();
        $instance5->setQuestion($q5);
        $instance5->setQuiz($quiz1);
        $manager->persist($instance5);

        $q6 = new Question();
        $q6->setName('ERP utilisé');
        $q6->setType(answertype::TEXT);
        $q6->setContent('Faire taire champ expression attitude. Puissance pas déchirer souvenir jardin frais. Impossible subir dont mer paraître bleu assez.');
        $manager->persist($q6);
        $instance6 = new QuestionInstance();
        $instance6->setQuestion($q6);
        $instance6->setQuiz($quiz1);
        $manager->persist($instance6);

        $q7 = new Question();
        $q7->setName('Besoin de connecteurs marketplace');
        $q7->setType(AnswerType::SINGLE_CHOICE);
        $q7->setContent('Puis tranquille rêve céder penser nommer. Obtenir principe comprendre. Chant pointe rond. Épais théâtre occuper.');
        $manager->persist($q7);
        $p7_0 = new Proposal();
        $p7_0->setContent('Oui');
        $p7_0->setQuestion($q7);
        $manager->persist($p7_0);
        $p7_1 = new Proposal();
        $p7_1->setContent('Non');
        $p7_1->setQuestion($q7);
        $manager->persist($p7_1);
        $instance7 = new QuestionInstance();
        $instance7->setQuestion($q7);
        $instance7->setQuiz($quiz1);
        $manager->persist($instance7);

        $q8 = new Question();
        $q8->setName('Marketplaces ciblées');
        $q8->setType(AnswerType::MULTI_CHOICE);
        $q8->setContent('Histoire lieu chanter événement plutôt condamner intérieur. Paraître ramener printemps corde plante rire.');
        $manager->persist($q8);
        $p8_0 = new Proposal();
        $p8_0->setContent('Amazon');
        $p8_0->setQuestion($q8);
        $manager->persist($p8_0);
        $p8_1 = new Proposal();
        $p8_1->setContent('eBay');
        $p8_1->setQuestion($q8);
        $manager->persist($p8_1);
        $p8_2 = new Proposal();
        $p8_2->setContent('Cdiscount');
        $p8_2->setQuestion($q8);
        $manager->persist($p8_2);
        $instance8 = new QuestionInstance();
        $instance8->setQuestion($q8);
        $instance8->setQuiz($quiz1);
        $manager->persist($instance8);

        $q9 = new Question();
        $q9->setName('Hébergez-vous votre SI ?');
        $q9->setType(AnswerType::SINGLE_CHOICE);
        $q9->setContent('Douleur anglais secret vent marquer assister cacher. Fuir beau dieu instant.');
        $manager->persist($q9);
        $p9_0 = new Proposal();
        $p9_0->setContent('Sur site');
        $p9_0->setQuestion($q9);
        $manager->persist($p9_0);
        $p9_1 = new Proposal();
        $p9_1->setContent('Dans le cloud');
        $p9_1->setQuestion($q9);
        $manager->persist($p9_1);
        $instance9 = new QuestionInstance();
        $instance9->setQuestion($q9);
        $instance9->setQuiz($quiz2);
        $manager->persist($instance9);

        $q10 = new Question();
        $q10->setName('Nom de votre solution cloud');
        $q10->setType(AnswerType::TEXT);
        $q10->setContent('Semblable note hiver personnage chez sou boire. Mal elle jour. Attirer froid alors fort chasser pitié crier. Théâtre morceau vêtir dominer triste fixe devant.');
        $manager->persist($q10);
        $instance10 = new QuestionInstance();
        $instance10->setQuestion($q10);
        $instance10->setQuiz($quiz2);
        $manager->persist($instance10);

        $q11 = new Question();
        $q11->setName('Connexion SSO souhaitée');
        $q11->setType(AnswerType::SINGLE_CHOICE);
        $q11->setContent('Savoir ou travailler angoisse travailler militaire. Séparer mériter justice plaisir. Soirée signer rose satisfaire écrire faute étendue.');
        $manager->persist($q11);
        $p11_0 = new Proposal();
        $p11_0->setContent('Oui');
        $p11_0->setQuestion($q11);
        $manager->persist($p11_0);
        $p11_1 = new Proposal();
        $p11_1->setContent('Non');
        $p11_1->setQuestion($q11);
        $manager->persist($p11_1);
        $instance11 = new QuestionInstance();
        $instance11->setQuestion($q11);
        $instance11->setQuiz($quiz2);
        $manager->persist($instance11);
        $manager->flush(); // Assure que tous les IDs sont bien générés

        // Condition : Si "Oui" à "Intégration ERP" → "ERP utilisé"
        $condition5_oui = new \App\Capture\Entity\Condition();
        $condition5_oui->setQuestionInstance($instance5);
        $condition5_oui->setProposalId($p5_0->getId()); // "Oui"
        $condition5_oui->setNextQuestionInstance($instance6);
        $manager->persist($condition5_oui);

        // Condition : Si "Non" à "Intégration ERP" → "Besoin de connecteurs marketplace"
        $condition5_non = new \App\Capture\Entity\Condition();
        $condition5_non->setQuestionInstance($instance5);
        $condition5_non->setProposalId($p5_1->getId()); // "Non"
        $condition5_non->setNextQuestionInstance($instance7);
        $manager->persist($condition5_non);

        // Condition : Si "Sur site" à "Hébergez-vous votre SI ?" → "Connexion SSO souhaitée"
        $condition9_site = new \App\Capture\Entity\Condition();
        $condition9_site->setQuestionInstance($instance9);
        $condition9_site->setProposalId($p9_0->getId()); // "Sur site"
        $condition9_site->setNextQuestionInstance($instance11);
        $manager->persist($condition9_site);

        // Condition : Si "Dans le cloud" à "Hébergez-vous votre SI ?" → "Nom de votre solution cloud"
        $condition9_cloud = new \App\Capture\Entity\Condition();
        $condition9_cloud->setQuestionInstance($instance9);
        $condition9_cloud->setProposalId($p9_1->getId()); // "Dans le cloud"
        $condition9_cloud->setNextQuestionInstance($instance10);
        $manager->persist($condition9_cloud);

        // Chaînage linéaire (non conditionnel)
        $instance1->setNextQuestionInstance($instance2); // Secteur activité → Nombre commandes
        $instance2->setNextQuestionInstance($instance3); // Nombre commandes → Canaux de vente
        $instance3->setNextQuestionInstance($instance4); // Canaux de vente → Fonctionnalités
        $instance4->setNextQuestionInstance($instance5); // Fonctionnalités → Intégration ERP
        $instance7->setNextQuestionInstance($instance8); // Besoin connecteurs → Marketplaces ciblées
        $instance8->setNextQuestionInstance($instance9); // Marketplaces → Hébergez-vous SI

        $manager->flush();
    }
}
