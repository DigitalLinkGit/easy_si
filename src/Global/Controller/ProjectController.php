<?php

namespace App\Global\Controller;

use App\Global\Form\ProjectType;
use App\Global\Entity\Project;
use App\Global\Entity\ParticipantAssignment;
use App\Capture\Entity\Capture;
use App\Capture\Entity\FormCapture;
use App\Capture\Entity\QuizCapture;
use App\Capture\Entity\CaptureInstance;
use App\Capture\Form\FormCaptureResponseType;
use App\Capture\Form\QuizCaptureResponseType;
use App\Global\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/project')]
final class ProjectController extends AbstractController
{
    #[Route(name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('global/project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('global/project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('global/project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        /* CAPTURES */
        $availableCaptures = $entityManager->getRepository(Capture::class)->findAll();

        /* PARTICIPANTS & ROLES */
        $existingRoleIds = array_map(
            fn(ParticipantAssignment $a) => $a->getRole()->getId(),
            $project->getParticipantAssignments()->toArray()
        );

        foreach ($project->getAllRolesFromCaptures() as $role) {
            if (!in_array($role->getId(), $existingRoleIds)) {
                $assignment = new ParticipantAssignment();
                $assignment->setRole($role);
                $project->addParticipantAssignment($assignment);
            }
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('global/project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
            'availableCaptures' => $availableCaptures,
        ]);
    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add-capture/{captureId}', name: 'app_project_add_capture', methods: ['GET'])]
    public function addCaptureInstance(Project $project, int $captureId, EntityManagerInterface $em): Response
    {
        $capture = $em->getRepository(Capture::class)->find($captureId);
        if (!$capture) {
            throw $this->createNotFoundException('Capture introuvable');
        }

        $instance = new CaptureInstance();
        $instance->setCapture($capture);
        $instance->setProject($project);
        $em->persist($instance);
        $em->flush();

        return new Response('OK');
    }

    #[Route('/{id}/delete-capture/{instanceId}', name: 'app_project_delete_capture', methods: ['GET'])]
    public function deleteCaptureInstance(Project $project, int $instanceId, EntityManagerInterface $em): Response
    {
        $instance = $em->getRepository(CaptureInstance::class)->find($instanceId);
        if (!$instance || $instance->getProject() !== $project) {
            throw $this->createNotFoundException('Capture introuvable');
        }

        $em->remove($instance);
        $em->flush();

        return $this->redirectToRoute('app_project_edit', ['id' => $project->getId()]);
    }

    #[Route('/{id}/respond/solo', name: 'app_project_respond_solo')]
    public function respondSolo(Project $project, Request $request): Response
    {
        $formBuilder = $this->createFormBuilder();
        $elementReferences = [];

        foreach ($project->getCaptureInstances() as $instance) {
            $capture = $instance->getCapture();

            foreach ($capture->getElements() as $element) {
                $type = match (true) {
                    $element instanceof \App\Capture\Entity\FormCapture => \App\Capture\Form\FormCaptureResponseType::class,
                    $element instanceof \App\Capture\Entity\QuizCapture => \App\Capture\Form\QuizCaptureResponseType::class,
                    default => null,
                };

                if ($type === null) {
                    continue;
                }

                $formBuilder->add('element_' . $element->getId(), $type, [
                    'label' => false,
                    'element' => $element,
                ]);

                $elementReferences[] = $element;
            }
        }
        dump($elementReferences);
        dump(array_keys($formBuilder->all()));
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 🟣 Persistance à faire ici
            $data = $form->getData();
            dump($data);
        }

        return $this->render('capture/collect/project_response_solo.html.twig', [
            'project' => $project,
            'form' => $form,
            'elements' => $elementReferences,
        ]);
    }
}
