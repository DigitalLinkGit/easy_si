<?php

namespace App\Capture\DataFixtures;

use App\Capture\Entity\Capture;
use App\Capture\Entity\CaptureInstance;
use App\Capture\Entity\CaptureElementInstance;
use App\Capture\Entity\ParticipantAssignment;
use App\Capture\Entity\QuizCapture;
use App\Capture\Entity\Role;
use App\Capture\Entity\Question;
use App\Capture\Entity\QuestionInstance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CaptureDemoFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create roles
        $roles = [];
        foreach ([
            'Métier client',
            'Métier presta',
            'Technique client',
            'Technique presta',
            'Chef de projet',
            'Sponsor'
        ] as $roleName) {
            $role = new Role();
            $role->setName($roleName);
            $roles[$roleName] = $role;
            $manager->persist($role);
        }

        // Create QuizCapture with questions
        $quiz1 = new QuizCapture();
        $quiz1->setName('Quiz sur les besoins métier');
        $quiz1->setDescription('Ce questionnaire vise à comprendre les besoins fonctionnels du client.');
        $quiz1->setRespondentRole($roles['Métier client']);
        $quiz1->setValidatorRole($roles['Chef de projet']);
        $manager->persist($quiz1);

        $quiz2 = new QuizCapture();
        $quiz2->setName('Quiz technique');
        $quiz2->setDescription('Ce questionnaire vise à comprendre les aspects techniques.');
        $quiz2->setRespondentRole($roles['Technique client']);
        $quiz2->setValidatorRole($roles['Technique presta']);
        $manager->persist($quiz2);

        // Create questions
        foreach (['Quels sont vos besoins ?', 'Quelles fonctionnalités attendez-vous ?'] as $qText) {
            $question = new Question();
            $question->setName('Besoin');
            $question->setMultipleChoice(false);
            $question->setContent($qText);
            $manager->persist($question);

            $instance = new QuestionInstance();
            $instance->setQuestion($question);
            $instance->setQuiz($quiz1);
            $manager->persist($instance);
        }

        foreach (['Quelles technologies utilisez-vous ?', 'Avez-vous des contraintes d’hébergement ?'] as $qText) {
            $question = new Question();
            $question->setName('Besoin 2');
            $question->setContent($qText);
            $question->setMultipleChoice(false);
            $manager->persist($question);

            $instance = new QuestionInstance();
            $instance->setQuestion($question);
            $instance->setQuiz($quiz2);
            $manager->persist($instance);
        }

        // Create capture and instance
        $capture = new Capture();
        $capture->setName('Capture projet ERP');
        $capture->setDescription('Capture initiale pour le projet ERP client');
        $capture->addElement($quiz1);
        $capture->addElement($quiz2);
        $manager->persist($capture);

        $captureInstance = new CaptureInstance();
        $captureInstance->setCapture($capture);
        $manager->persist($captureInstance);

        // Create element instances
        $element1 = new CaptureElementInstance();
        $element1->setCaptureInstance($captureInstance);
        $element1->setElement($quiz1);
        $element1->setRespondentEmail('metier@client.com');
        $element1->setValidatorEmail('chef@projet.com');
        $element1->setLinkToken('abc123');
        $element1->setLinkExpiresAt(new \DateTime('+7 days'));
        $element1->setStatus('pending');
        $manager->persist($element1);

        $element2 = new CaptureElementInstance();
        $element2->setCaptureInstance($captureInstance);
        $element2->setElement($quiz2);
        $element2->setRespondentEmail('tech@client.com');
        $element2->setValidatorEmail('tech@presta.com');
        $element2->setLinkToken('xyz789');
        $element2->setLinkExpiresAt(new \DateTime('+7 days'));
        $element2->setStatus('pending');
        $manager->persist($element2);

        // Assignments
        $role = new Role();
        $role->setName('Métier client');
        $manager->persist($role);

        $assignment1 = new ParticipantAssignment();
        $assignment1->setCaptureInstance($captureInstance);
        $assignment1->setEmail('metier@client.com');
        $assignment1->setRole($role);
        $manager->persist($assignment1);

        $role = new Role();
        $role->setName('Technique client');
        $manager->persist($role);

        $assignment2 = new ParticipantAssignment();
        $assignment2->setCaptureInstance($captureInstance);
        $assignment2->setEmail('tech@client.com');
        $assignment2->setRole($role);
        $manager->persist($assignment2);

        $manager->flush();
    }
}
