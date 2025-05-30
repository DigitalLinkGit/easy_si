<?php

namespace App\Design\Controller;

use App\Design\Entity\Flow;
use App\Design\Entity\Interaction;
use App\Design\Form\FlowType;
use App\Design\Form\MiniInteractionType;
use App\Design\Repository\FlowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/flow')]
final class FlowController extends AbstractController
{
    #[Route(name: 'app_flow_index', methods: ['GET'])]
    public function index(FlowRepository $flowRepository): Response
    {
        return $this->render('design/flow/index.html.twig', [
            'flows' => $flowRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_flow_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $flow = new Flow();
        $form = $this->createForm(FlowType::class, $flow);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            dump($form->getErrors(true));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($flow);
            $entityManager->flush();

            return $this->redirectToRoute('app_flow_edit', [
                'id' => $flow->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('design/flow/new.html.twig', [
            'flow' => $flow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flow_show', methods: ['GET'])]
    public function show(Flow $flow): Response
    {
        return $this->render('design/flow/show.html.twig', [
            'flow' => $flow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_flow_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flow $flow, EntityManagerInterface $entityManager): Response
    {
        // Formulaire principal (flow + interactions)
        $form = $this->createForm(FlowType::class, $flow);
        $form->handleRequest($request);

        // Formulaire modal : ajout d’une interaction au flow
        $interaction = new Interaction();
        $interaction->setFlow($flow);

        $interactionForm = $this->createForm(MiniInteractionType::class, $interaction, [
            'action' => $this->generateUrl('app_flow_add_interaction', ['id' => $flow->getId()]),
            'method' => 'POST',
        ]);

        // Traitement du flow (pas de traitement interaction ici)
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_flow_edit', ['id' => $flow->getId()]);
        }

        return $this->render('flow/edit.html.twig', [
            'flow' => $flow,
            'form' => $form->createView(),
            'interactionForm' => $interactionForm->createView(),
        ]);
    }

    #[Route('/{id}/add-interaction', name: 'app_flow_add_interaction', methods: ['POST'])]
    public function addInteraction(Request $request, Flow $flow, EntityManagerInterface $em): Response
    {
        $interaction = new Interaction();
        $interaction->setFlow($flow);

        $form = $this->createForm(MiniInteractionType::class, $interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($interaction);
            $em->flush();

            $this->addFlash('success', 'Nouvelle interaction ajoutée.');
        } else {
            $this->addFlash('danger', 'Erreur lors de l’ajout de l’interaction.');
        }

        return $this->redirectToRoute('app_flow_edit', [
            'id' => $flow->getId()
        ]);
    }

    #[Route('/{id}', name: 'app_flow_delete', methods: ['POST'])]
    public function delete(Request $request, Flow $flow, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $flow->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($flow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_flow_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/interaction/{id}/delete', name: 'app_flow_delete_interaction', methods: ['POST'])]
    public function deleteInteraction(Request $request, Interaction $interaction, EntityManagerInterface $entityManager): Response
    {
        $flow = $interaction->getFlow();
        if ($this->isCsrfTokenValid('delete_interaction_' . $interaction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($interaction);
            $entityManager->flush();

            $this->addFlash('success', 'Interaction supprimé avec succès.');
        } else {
            $this->addFlash('danger', 'Échec de la suppression de l\'interaction.');
        }

        return $this->redirectToRoute('app_flow_edit', [
            'id' => $flow?->getId()
        ]);
    }
}
