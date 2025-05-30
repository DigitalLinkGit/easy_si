<?php

namespace App\Controller;

use App\Entity\TutorialStep;
use App\Form\TutorialStepType;
use App\Repository\TutorialStepRepository;
use App\Repository\TutorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tutorial')]
final class TutorialStepController extends AbstractController
{
    #[Route('tutorial', name:'app_tutorial_step_index', methods: ['GET'])]
    public function index(TutorialStepRepository $tutorialStepRepository): Response
    {
        return $this->render('tutorial_step/index.html.twig', [
            'tutorial_steps' => $tutorialStepRepository->findAll(),
        ]);
    }

    #[Route('tutorial/{tutorialId}/step/new', name: 'app_tutorial_step_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TutorialRepository $tutoRepo, EntityManagerInterface $entityManager, int $tutorialId): Response
    {
        $tutorial = $tutoRepo->find($tutorialId);
        if (!$tutorial) {
            throw $this->createNotFoundException('Tutoriel non trouvé');
        }

        $tutorialStep = new TutorialStep();
        $tutorialStep->setTutorial($tutorial);
        $form = $this->createForm(TutorialStepType::class, $tutorialStep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tutorialStep);
            $entityManager->flush();

            return $this->redirectToRoute('app_tutorial_step_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tutorial_step/new.html.twig', [
            'tutorial_step' => $tutorialStep,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tutorial_step_show', methods: ['GET'])]
    public function show(TutorialStep $tutorialStep): Response
    {
        return $this->render('tutorial_step/show.html.twig', [
            'tutorial_step' => $tutorialStep,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tutorial_step_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TutorialStep $tutorialStep, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TutorialStepType::class, $tutorialStep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tutorial_step_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tutorial_step/edit.html.twig', [
            'tutorial_step' => $tutorialStep,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tutorial_step_delete', methods: ['POST'])]
    public function delete(Request $request, TutorialStep $tutorialStep, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tutorialStep->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tutorialStep);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tutorial_step_index', [], Response::HTTP_SEE_OTHER);
    }
}
