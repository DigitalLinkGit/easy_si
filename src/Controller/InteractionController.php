<?php

namespace App\Controller;

use App\Entity\Interaction;
use App\Entity\Element;
use App\Form\InteractionType;
use App\Entity\Service;
use App\Form\ServiceMinimalType;
use App\Repository\InteractionRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/interaction')]
class InteractionController extends AbstractController
{
    #[Route('/', name: 'app_interaction_index', methods: ['GET'])]
    public function index(InteractionRepository $interactionRepository): Response
    {
        return $this->render('interaction/index.html.twig', [
            'interactions' => $interactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_interaction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $interaction = new Interaction();
        $form = $this->createForm(InteractionType::class, $interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($interaction);
            $em->flush();

            return $this->redirectToRoute('app_interaction_index');
        }

        return $this->render('interaction/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_interaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Interaction $interaction, EntityManagerInterface $em): Response
    {
        // Formulaire principal Interaction
        $form = $this->createForm(InteractionType::class, $interaction);
        $form->handleRequest($request);

        // Formulaires ServiceMinimalType préremplis pour les modales
        $serviceIn = new Service();
        $serviceIn->setElement($interaction->getElementIn());
        $serviceInForm = $this->createForm(ServiceMinimalType::class, $serviceIn, [
            'action' => $this->generateUrl('app_interaction_add_service', [
                'id' => $interaction->getId(),
                'element' => $interaction->getElementIn()?->getId(),
            ]),

            'method' => 'POST',
        ]);

        $serviceOut = new Service();
        $serviceOut->setElement($interaction->getElementOut());
        $serviceOutForm = $this->createForm(ServiceMinimalType::class, $serviceOut, [
            'action' => $this->generateUrl('app_interaction_add_service', [
                'id' => $interaction->getId(),
                'element' => $interaction->getElementIn()?->getId(),
            ]),

            'method' => 'POST',
        ]);

        // Sauvegarde de l'interaction
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Interaction mise à jour.');
            return $this->redirectToRoute('app_interaction_edit', [
                'id' => $interaction->getId()
            ]);
        }

        return $this->render('interaction/edit.html.twig', [
            'form' => $form->createView(),
            'interaction' => $interaction,
            'serviceInForm' => $serviceInForm->createView(),
            'serviceOutForm' => $serviceOutForm->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_interaction_show', methods: ['GET'])]
    public function show(Interaction $interaction): Response
    {
        return $this->render('interaction/show.html.twig', [
            'interaction' => $interaction,
        ]);
    }

    #[Route('/{id}', name: 'app_interaction_delete', methods: ['POST'])]
    public function delete(Request $request, Interaction $interaction, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $interaction->getId(), $request->request->get('_token'))) {
            $em->remove($interaction);
            $em->flush();
        }

        return $this->redirectToRoute('app_interaction_index');
    }

    #[Route('/{id}/add-service', name: 'app_interaction_add_service', methods: ['POST'])]
    public function addService(Request $request, Interaction $interaction, EntityManagerInterface $em): Response
    {
        $elementId = $request->query->get('element');

        if (!$elementId) {
            $this->addFlash('danger', 'Aucun élément spécifié.');
            return $this->redirectToRoute('app_interaction_edit', ['id' => $interaction->getId()]);
        }

        $element = $em->getRepository(Element::class)->find($elementId);
        if (!$element) {
            $this->addFlash('danger', 'Élément introuvable.');
            return $this->redirectToRoute('app_interaction_edit', ['id' => $interaction->getId()]);
        }

        $service = new Service();
        $service->setElement($element);

        $form = $this->createForm(ServiceMinimalType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($service);
            $em->flush();

            $this->addFlash('success', 'Service créé avec succès.');
        } else {
            $this->addFlash('danger', 'Erreur lors de la création du service.');
        }

        return $this->redirectToRoute('app_interaction_edit', ['id' => $interaction->getId()]);
    }

    #[Route('/services-by-element/{id}', name: 'app_service_by_element', methods: ['GET'])]
    public function getServicesByElement(Element $element, ServiceRepository $serviceRepository): JsonResponse
    {
        $services = $serviceRepository->findBy(['element' => $element]);

        $data = array_map(function ($service) {
            return [
                'id' => $service->getId(),
                'label' => $service->getLabel(),
            ];
        }, $services);

        return $this->json($data);
    }
}
