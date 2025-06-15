<?php

namespace App\Capture\DataFixtures;

use App\Capture\Entity\Capture;
use App\Capture\Entity\FormCapture;
use App\Capture\Entity\QuizCapture;
use App\Capture\Entity\Question;
use App\Capture\Entity\Proposal;
use App\Capture\Entity\QuestionInstance;
use App\Capture\Enum\AnswerType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CaptureElementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $q1 = new Question();
        $q1->setName('Q1');
        $q1->setType(AnswerType::TEXT);
        $q1->setContent('Question 1');
        $manager->persist($q1);

        $q2 = new Question();
        $q2->setName('Q2');
        $q2->setType(AnswerType::NUMBER);
        $q2->setContent('Question 2');
        $manager->persist($q2);

        $q3 = new Question();
        $q3->setName('Q3');
        $q3->setType(AnswerType::DATE);
        $q3->setContent('Question 3');
        $manager->persist($q3);

        $q4 = new Question();
        $q4->setName('Q4');
        $q4->setType(AnswerType::DATE);
        $q4->setContent('Question 4');
        $manager->persist($q4);

        $quiz0 = new QuizCapture();
        $quiz0->setName('Quiz test');
        $quiz0->setDescription('Quiz utilisé pour les tests');
        $quiz0->addQuestion($q1);
        $quiz0->addQuestion($q2);
        $quiz0->addQuestion($q3);
        $quiz0->addQuestion($q4);
        $manager->persist($quiz0);

        $form1 = new FormCapture();
        $form1->setName('Form test');
        $form1->setDescription('Form utilisé pour les tests');
        $manager->persist($form1);

        $capture = new Capture();
        $capture->setName('Capture test');
        $capture->setDescription('Capture utilisée pour les tests');
        $capture->addElement($quiz0);
        $capture->addElement($form1);
        $manager->persist($capture);

        $manager->flush();
    }
}
