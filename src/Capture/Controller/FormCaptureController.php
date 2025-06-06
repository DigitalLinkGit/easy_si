<?php
namespace App\Capture\Controller;

use App\Capture\Entity\FormCapture;
use App\Capture\Form\FormCaptureType;
use App\Capture\Repository\FormCaptureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/form-capture')]
class FormCaptureController extends AbstractController
{
    #[Route('/', name: 'app_form_capture_index', methods: ['GET'])]
    public function index(FormCaptureRepository $repository): Response
    {
        return $this->render('capture/compose/form_capture/index.html.twig', [
            'form_captures' => $repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_form_capture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $formCapture = new FormCapture();
        $form = $this->createForm(FormCaptureType::class, $formCapture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($formCapture);
            $em->flush();
            return $this->redirectToRoute('app_form_capture_index');
        }

        return $this->render('capture/compose/form_capture/new.html.twig', [
            'form_capture' => $formCapture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_form_capture_edit', methods: ['GET', 'POST'])]
    public function edit(FormCapture $formCapture, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FormCaptureType::class, $formCapture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_form_capture_index');
        }

        return $this->render('capture/compose/form_capture/edit.html.twig', [
            'form_capture' => $formCapture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_form_capture_delete', methods: ['POST'])]
    public function delete(FormCapture $formCapture, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formCapture->getId(), $request->request->get('_token'))) {
            $em->remove($formCapture);
            $em->flush();
        }

        return $this->redirectToRoute('app_form_capture_index');
    }
}
