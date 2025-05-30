<?php

namespace App\Capture\Controller;

use App\Capture\Entity\Question;
use App\Capture\Form\QuestionType;
use App\Capture\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

#[Route('/question')]
final class QuestionController extends AbstractController
{
    #[Route(name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository): Response
    {
        return $this->render('capture/compose/quiz-capture/question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, LoggerInterface $logger): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    foreach ($question->getProposals() as $proposal) {
                        $proposal->setQuestion($question);
                    }

                    $em->persist($question);
                    $em->flush();

                    $this->addFlash('success', 'Question créée avec succès.');
                    return $this->redirectToRoute('app_question_index');
                } catch (\Throwable $e) {
                    $logger->error('Erreur lors de la création de la question : ' . $e->getMessage(), ['exception' => $e]);
                    $this->addFlash('danger', 'Une erreur est survenue lors de l’enregistrement.');
                }
            } else {
                $this->addFlash('warning', 'Le formulaire contient des erreurs.');
            }
        }

        return $this->render('capture/compose/quiz-capture/question/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('capture/compose/quiz-capture/question/show.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, EntityManagerInterface $em, LoggerInterface $logger): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $em->flush();
                    $this->addFlash('success', 'Question mise à jour avec succès.');
                    return $this->redirectToRoute('app_question_index');
                } catch (\Throwable $e) {
                    $logger->error('Erreur lors de la mise à jour de la question : ' . $e->getMessage(), ['exception' => $e]);
                    $this->addFlash('danger', 'Une erreur est survenue lors de la mise à jour.');
                }
            } else {
                $this->addFlash('warning', 'Le formulaire contient des erreurs.');
            }
        }

        return $this->render('capture/compose/quiz-capture/question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Question $question,
        EntityManagerInterface $em,
        LoggerInterface $logger
    ): Response {
        $id = $question->getId();

        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            try {
                $em->remove($question);
                $em->flush();

                $this->addFlash('success', 'La question a été supprimée avec succès.');
            } catch (ForeignKeyConstraintViolationException $e) {
                $logger->warning("Suppression impossible : la question $id est utilisée ailleurs.", [
                    'exception' => $e,
                ]);

                // Vérification manuelle dans les QuestionInstance par exemple
                $usages = $question->getInstances(); // Assuming mappedBy="question"
                if (count($usages) > 0) {
                    $sectionNames = array_map(fn($instance) => $instance->getSection()?->getName(), $usages->toArray());
                    $sectionList = implode(', ', array_filter($sectionNames));

                    $this->addFlash('danger', "Impossible de supprimer cette question : elle est utilisée dans la ou les section(s) : {$sectionList}.");
                } else {
                    $this->addFlash('danger', 'Impossible de supprimer cette question : elle est utilisée ailleurs dans le système.');
                }
            }
        }

        return $this->redirectToRoute('app_question_index');
    }
}
