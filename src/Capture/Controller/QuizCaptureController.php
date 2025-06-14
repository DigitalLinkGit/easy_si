<?php

namespace App\Capture\Controller;

use App\Capture\Entity\QuizCapture;
use App\Capture\Entity\Question;
use App\Capture\Entity\Condition;
use App\Capture\Form\QuizCaptureType;
use App\Capture\Form\QuestionType;
use App\Capture\Form\PreviewType;
use App\Capture\Repository\QuizCaptureRepository;
use App\Capture\Repository\QuestionRepository;
use App\Capture\Repository\ProposalRepository;
use App\Capture\Repository\QuestionInstanceRepository;
use App\Capture\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Capture\Service\GraphBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

#[Route('/quiz')]
final class QuizCaptureController extends AbstractController
{
    #[Route(name: 'app_quiz_index', methods: ['GET'])]
    public function index(Request $request, QuizCaptureRepository $quizRepository): Response
    {
        $captureId = $request->query->get('captureId');
        return $this->render('capture/compose/quiz-capture/quiz/index.html.twig', [
            'quizzes' => $quizRepository->findAll(),
            'captureId' => $captureId,
        ]);
    }

    #[Route('/new', name: 'app_quiz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionInstanceRepository $qiRepo, GraphBuilder $graphBuilder, EntityManagerInterface $em): Response
    {
        $quiz = new QuizCapture();
        $form = $this->createForm(QuizCaptureType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute('app_quiz_edit', ['id' => $quiz->getId()]);
        }
        return $this->render('capture/compose/quiz-capture/quiz/new.html.twig', [
            'questions'=> $quiz->getQuestions(),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quiz_show', methods: ['GET'])]
    public function show(QuizCapture $quiz): Response
    {
        $form = $this->createForm(QuizCaptureType::class, $quiz, [
            'disabled' => true,
        ]);

        return $this->render('capture/compose/quiz-capture/quiz/show.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quiz_edit')]
    public function edit(Request $request, QuizCapture $quiz, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(QuizCaptureType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'quiz mis à jour.');
            return $this->redirectToRoute('app_quiz_edit', ['id' => $quiz->getId()]);
        }

        $questions = $quiz->getQuestions();

        foreach ($questions as $question) {
            $question->getProposals()->count(); // force le chargement des propositions
        }

        return $this->render('capture/compose/quiz-capture/quiz/edit.html.twig', [
            'form' => $form->createView(),
            'questions'=>$questions,
            'quiz'=>$quiz,

        ]);
    }

    #[Route('/{id}', name: 'app_quiz_delete', methods: ['POST'])]
    public function delete(Request $request, QuizCapture $quiz, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quiz->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($quiz);
            $em->flush();
        }

        return $this->redirectToRoute('app_quiz_index');
    }
    /*
    #[Route('/{quizId}/add-question', name: 'app_quiz_add_question')]
    public function addQuestion(Request $request, int $quizId, EntityManagerInterface $em, QuizCaptureRepository $quizRepo, QuestionRepository $questionRepo, CategoryRepository $categoryRepo): Response
    {
        $quiz = $quizRepo->find($quizId);
        if (!$quiz) {
            throw $this->createNotFoundException('quiz non trouvé');
        }

        $categoryId = $request->query->get('category');
        $search = $request->query->get('q');

        $qb = $questionRepo->createQueryBuilder('q')
            ->leftJoin('q.category', 'c')
            ->addSelect('c');

        if ($categoryId) {
            $qb->andWhere('c.id = :categoryId')->setParameter('categoryId', $categoryId);
        }

        if ($search) {
            $qb->andWhere('q.name LIKE :search OR q.content LIKE :search OR c.name LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        // Exclure les questions déjà utilisées dans cette quiz
        $usedQuestionIds = array_map(
            fn(QuestionInstance $instance) => $instance->getQuestion()->getId(),
            $quiz->getQuestionsInstances()->toArray()
        );

        if (!empty($usedQuestionIds)) {
            $qb->andWhere($qb->expr()->notIn('q.id', ':used'))
                ->setParameter('used', $usedQuestionIds);
        }

        $questions = $qb->getQuery()->getResult();
        $categories = $categoryRepo->findAll();

        return $this->render('capture/compose/quiz-capture/quiz/add_question.html.twig', [
            'quiz' => $quiz,
            'questions' => $questions,
            'categories' => $categories,
            'previousInstanceId' => $request->query->get('previousInstanceId'),
            'proposalId' => $request->query->get('proposalId'),
        ]);
    }
    */
    /*
    #[Route('/{quizId}/attach-question', name: 'app_quiz_attach_question_instance')]
    public function linkQuestion(int $quizId, Request $request, EntityManagerInterface $em, QuizCaptureRepository $quizRepo, QuestionRepository $questionRepo, QuestionInstanceRepository $instanceRepo, ProposalRepository $proposalRepo): Response
    {
        $quiz = $quizRepo->find($quizId);
        if (!$quiz) {
            throw $this->createNotFoundException('quiz introuvable.');
        }

        $question = $questionRepo->find($request->query->get('questionId'));
        if (!$question) {
            throw $this->createNotFoundException('Question introuvable.');
        }

        $previousInstanceId = $request->query->get('previousInstanceId');
        $proposalId = $request->query->get('proposalId');
        //dd($proposalId);

        $newInstance = new Question();
        $newInstance->setQuiz($quiz);
        $newInstance->setQuestion($question);



        if ($previousInstanceId) {
            $previous = $instanceRepo->find($previousInstanceId);
            if (!$previous) {
                throw $this->createNotFoundException('Instance précédente introuvable.');
            }

            //$newInstance->setPreviousQuestionInstance($previous);
            $newInstance->setLevel($previous->getLevel() + 1);
            if ($proposalId) {
                $proposal = $proposalRepo->find($proposalId);
                if (!$proposal) {
                    throw $this->createNotFoundException('Proposition introuvable.');
                }

                foreach ($previous->getConditions() as $existing) {
                    if ($existing->getProposalId() === $proposal->getId()) {
                        throw $this->createNotFoundException('Une condition existe déjà pour cette proposition.');
                    }
                }

                $condition = new Condition();
                $condition->setQuestionInstance($previous);
                $condition->setProposalId($proposal->getId());
                $condition->setNextQuestionInstance($newInstance);
                $em->persist($condition);
            } else {
                $previous->setNextQuestionInstance($newInstance);
            }
            $em->persist($previous);
        }
        $em->persist($newInstance);
        $em->flush();

        $em->refresh($newInstance);
        $em->refresh($newInstance->getQuestion());

        $this->addFlash('success', 'Question ajoutée avec succès.');

        return $this->redirectToRoute('app_quiz_edit', [
            'id' => $quiz->getId(),
        ]);
    }

    #[Route('/question/{id}', name: 'app_quiz_question_modal')]
    public function modal(int $id, QuestionInstanceRepository $repository): Response
    {
        $instance = $repository->find($id);

        if (!$instance) {
            throw $this->createNotFoundException('QuestionInstance introuvable');
        }

        return $this->render('global/components/modal/_modal_question.html.twig', [
            'instance' => $instance,
        ]);
    }

    #[Route('/{quizId}/unlink/{instanceId}/{proposalId?}', name: 'app_quiz_unlink_question')]
    public function unlinkQuestion(int $quizId, EntityManagerInterface $em, QuestionInstanceRepository $instanceRepo, int $instanceId, ?int $proposalId = null)
    {
        $instance = $instanceRepo->find($instanceId);
        if (!$instance) {
            throw $this->createNotFoundException();
        }

        if ($proposalId) {
            $instance->removeConditionByProposalId($proposalId);
        } else {
            $instance->removeNextQuestionInstance();
        }

        $quiz = $instance->getQuiz();
        $quiz->removeQuestionInstance($instance);
        $em->remove($instance);
        $em->flush();

        return $this->redirectToRoute('app_quiz_edit', [
            'id' => $instance->getQuiz()->getId(),
        ]);
    }

    #[Route('/question/{instanceId}/render', name: 'app_quiz_render_question', methods: ['GET', 'POST'])]
    public function renderQuestionInstance(
        int $instanceId,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $instance = $em->getRepository(QuestionInstance::class)->find($instanceId);

        if (!$instance) {
            throw $this->createNotFoundException("QuestionInstance #$instanceId introuvable.");
        }

        $form = $this->createFormBuilder($instance)
            ->add('renderTemplate', TextareaType::class, [
                'label' => 'Texte de rendu avec variables',
                'attr' => ['class' => 'form-control', 'rows' => 10],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $template = $form->get('renderTemplate')->getData() ?? '';
            $template = $template . "\n";
            $instance->setRenderTemplate($template);

            $em->flush();

            $this->addFlash('success', 'Modèle de rendu enregistré.');
            return $this->redirectToRoute('app_quiz_render_question', ['instanceId' => $instanceId]);
        }

        return $this->render('capture/compose/quiz-capture/quiz/render_instance.html.twig', [
            'instance' => $instance,
            'question' => $instance->getQuestion(),
            'quiz' => $instance->getQuiz(),
            'form' => $form->createView(),
        ]);
    }
    */
    /* TEST TUTO
    #[Route('/new', name: 'app_quiz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionInstanceRepository $qiRepo, GraphBuilder $graphBuilder, EntityManagerInterface $em, TutorialRepository $tutorialRepository): Response
    {
        $quiz = new QuizCapture();
        $form = $this->createForm(QuizCaptureType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute('app_quiz_edit', [
                'quiz' => $quiz,
                'form' => $form,
                'id' => $quiz->getId(),
            ]);
        }
        $graphData = $graphBuilder->buildForSection($quiz, $qiRepo);
        $currentRoute = $request->attributes->get('_route');
        $tutorial = $tutorialRepository->findOneBy(['route' => $currentRoute]);
        return $this->render('capture/compose/quiz-capture/quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form,
            'tutorial' => $tutorial,
            'graphData' => $graphData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quiz_edit')]
    public function edit(Request $request, QuestionInstanceRepository $qiRepo, GraphBuilder $graphBuilder, TutorialRepository $tutoRepo, QuizCapture $quiz, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(QuizCaptureType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'quiz mis à jour.');
            return $this->redirectToRoute('app_quiz_edit', ['id' => $quiz->getId()]);
        }

        $instances = $quiz->getQuestionsInstances();

        foreach ($instances as $instance) {
            $instance->getQuestion()->getProposals()->count(); // force le chargement des propositions
            $instance->getConditions()->count(); // force le chargement des conditions
        }
        $graphData = $graphBuilder->buildForSection($quiz, $qiRepo);
        $sorted = iterator_to_array($instances);
        usort($sorted, fn($a, $b) => $a->getId() <=> $b->getId());

            //Charge le tuto correspondant à la route si il existe
            //TODO: a factoriser pour utilisation dans tous les controller
        $currentRoute = $request->attributes->get('_route');
        $tutorial = $tutoRepo->findOneWithStepsByRoute($currentRoute);

            //test de dé sérialisation car la modal tuto n'y arrive pas
            //c'est dégueu !!!
            //TODO: trouver une bonne partique
        $tutorialData = null;

        if ($tutorial) {
            $tutorialData = [
                'id' => $tutorial->getId(),
                'name' => $tutorial->getName(),
                'description' => $tutorial->getDescription(),
                'steps' => array_map(function ($step) {
                    return [
                        'id' => $step->getId(),
                        'number' => $step->getNumber(),
                        'content' => $step->getContent(),
                        'domElement' => $step->getDomElement(),
                    ];
                }, $tutorial->getSteps()->toArray()),
            ];
        }

        return $this->render('capture/compose/quiz-capture/quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
            'graphData' => $graphData,
            'instances' => $instances,
            'tutorial' => $tutorialData,
        ]);
    }*/
}
