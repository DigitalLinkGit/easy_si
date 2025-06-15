<?php

namespace App\Controller\App\Capture\Controller;

use App\Capture\Entity\CaptureInstance;
use App\Form\Capture\Entity\CaptureInstanceForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app/capture/controller/capture/instance')]
final class CaptureInstanceController extends AbstractController
{
    #[Route(name: 'app_capture_controller_capture_instance_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $captureInstances = $entityManager
            ->getRepository(CaptureInstance::class)
            ->findAll();

        return $this->render('app/capture/controller/capture_instance/index.html.twig', [
            'capture_instances' => $captureInstances,
        ]);
    }

    #[Route('/new', name: 'app_capture_controller_capture_instance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $captureInstance = new CaptureInstance();
        $form = $this->createForm(CaptureInstanceForm::class, $captureInstance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($captureInstance);
            $entityManager->flush();

            return $this->redirectToRoute('app_capture_controller_capture_instance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('app/capture/controller/capture_instance/new.html.twig', [
            'capture_instance' => $captureInstance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_capture_controller_capture_instance_show', methods: ['GET'])]
    public function show(CaptureInstance $captureInstance): Response
    {
        return $this->render('app/capture/controller/capture_instance/show.html.twig', [
            'capture_instance' => $captureInstance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_capture_controller_capture_instance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CaptureInstance $captureInstance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CaptureInstanceForm::class, $captureInstance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_capture_controller_capture_instance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('app/capture/controller/capture_instance/edit.html.twig', [
            'capture_instance' => $captureInstance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_capture_controller_capture_instance_delete', methods: ['POST'])]
    public function delete(Request $request, CaptureInstance $captureInstance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$captureInstance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($captureInstance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_capture_controller_capture_instance_index', [], Response::HTTP_SEE_OTHER);
    }
}
