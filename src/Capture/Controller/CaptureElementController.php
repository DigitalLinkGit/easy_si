<?php

namespace App\Capture\Controller;

use App\Capture\Entity\CaptureElement;
use App\Capture\Form\CaptureElementRenderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CaptureElementController extends AbstractController
{
    #[Route('/capture-element/{id}/preview', name: 'app_capture_element_preview', methods: ['GET', 'POST'])]
    public function preview(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $element = $em->getRepository(CaptureElement::class)->find($id);

        $form = $this->createFormBuilder([
            'renderTitle' => $element->getRenderTitle(),
            'renderTitleLevel' => $element->getRenderTitleLevel(),
        ])
            ->add('renderTitle', null, ['label' => 'Titre du chapitre'])
            ->add('renderTitleLevel', null, ['label' => 'Niveau de titre'])
            ->getForm();

        if (!$element) {
            throw $this->createNotFoundException("Élément de capture #$id introuvable.");
        }

        if ($request->isMethod('POST')) {
            $element->setRenderTitle($request->request->get('title') ?? null);
            $element->setRenderTitleLevel((int) $request->request->get('titleLevel') ?: null);

            $em->flush();
            $this->addFlash('success', 'Titre mis à jour.');
            return $this->redirectToRoute('app_capture_element_preview', ['id' => $element->getId()]);
        }

        $rendered = $element->render([]);

        return $this->render('capture/compose/capture-element/preview_modal.html.twig', [
            'element' => $element,
            'rendered' => $rendered,
            'previewForm' => $form->createView(),
        ]);
    }

    #[Route('/capture-element/{id}/render', name: 'capture_element_edit_render')]
    public function editRender(CaptureElement $element, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CaptureElementRenderType::class, $element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($element->getResults() as $result) {
                $result->setElement($element);
            }
            $em->flush();

            $this->addFlash('success', 'Rendu mis à jour avec succès.');
            return $this->redirectToRoute('capture_element_edit_render', ['id' => $element->getId()]);
        }

        // Variables disponibles pour l’interpolation
        $variables = method_exists($element, 'getInterpolableVariables')
            ? $element->getInterpolableVariables()
            : [];

        return $this->render('capture/compose/capture-element/render_editor.html.twig', [
            'form' => $form->createView(),
            'element' => $element,
            'variables' => $variables,
        ]);
    }
}
