<?php

namespace App\Capture\Controller;

use App\Capture\Entity\Capture;
use App\Capture\Form\CaptureType;
use App\Capture\Repository\QuizCaptureRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Capture\Repository\CaptureElementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/capture')]
final class CaptureController extends AbstractController
{
    #[Route(name: 'app_capture_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $captures = $entityManager
            ->getRepository(Capture::class)
            ->findAll();

        return $this->render('capture/compose/capture/index.html.twig', [
            'captures' => $captures,
        ]);
    }

    #[Route('/new', name: 'app_capture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $capture = new Capture();
        $form = $this->createForm(CaptureType::class, $capture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($capture);
            $entityManager->flush();

            return $this->redirectToRoute('app_capture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('capture/compose/capture/new.html.twig', [
            'capture' => $capture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_capture_show', methods: ['GET'])]
    public function show(Capture $capture): Response
    {
        return $this->render('capture/compose/capture/show.html.twig', [
            'capture' => $capture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_capture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Capture $capture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CaptureType::class, $capture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_capture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('capture/compose/capture/edit.html.twig', [
            'capture' => $capture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_capture_delete', methods: ['POST'])]
    public function delete(Request $request, Capture $capture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $capture->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($capture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_capture_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add-element/{elementId}', name: 'app_capture_add_element', methods: ['GET'])]
    public function addElement(Capture $capture, int $elementId, QuizCaptureRepository $quizRepo, EntityManagerInterface $em): Response
    {
        $quiz = $quizRepo->find($elementId);
        if (!$quiz) {
            throw $this->createNotFoundException('QuizCapture introuvable');
        }

        $capture->addElement($quiz);
        $em->flush();

        return $this->redirectToRoute('app_capture_edit', ['id' => $capture->getId()]);
    }

    #[Route('/capture/compose/capture/{id}/delete-element/{elementId}', name: 'app_capture_delete_element', methods: ['GET'])]
    public function deleteElement(Capture $capture,int $elementId,CaptureElementRepository $elementRepo,EntityManagerInterface $em): Response {
        $element = $elementRepo->find($elementId);
        if (!$element) {
            throw $this->createNotFoundException('CaptureElement introuvable');
        }

        $capture->removeElement($element);
        $em->flush();

        return $this->redirectToRoute('app_capture_edit', ['id' => $capture->getId()]);
    }
}
