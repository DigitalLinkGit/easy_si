<?php

namespace App\Controller;

use App\Entity\Tutorial;
use App\Form\TutorialType;
use App\Repository\TutorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/tutorial')]
final class TutorialController extends AbstractController
{
    #[Route(name: 'app_tutorial_index', methods: ['GET'])]
    public function index(TutorialRepository $tutorialRepository): Response
    {
        return $this->render('tutorial/index.html.twig', [
            'tutorials' => $tutorialRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tutorial_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RouterInterface $router,EntityManagerInterface $entityManager): Response
    {
        $allRoutes = $router->getRouteCollection()->all();
        // Filtrage des routes utiles (par convention "app_")
        $routeChoices = [];
        foreach ($allRoutes as $name => $route) {
            if (str_starts_with($name, 'app_')) {
                $routeChoices[$name] = $name;
            }
        }
        
        
        $tutorial = new Tutorial();
        $form = $this->createForm(TutorialType::class, $tutorial,['routes' => $routeChoices]);
        $form->handleRequest($request);
        
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tutorial);
            $entityManager->flush();

            return $this->redirectToRoute('app_tutorial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tutorial/new.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tutorial_show', methods: ['GET'])]
    public function show(Tutorial $tutorial): Response
    {
        return $this->render('tutorial/show.html.twig', [
            'tutorial' => $tutorial,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tutorial_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,  RouterInterface $router,Tutorial $tutorial, EntityManagerInterface $entityManager): Response
    {
        $allRoutes = $router->getRouteCollection()->all();
        // Filtrage des routes utiles (par convention "app_")
        $routeChoices = [];
        foreach ($allRoutes as $name => $route) {
            if (str_starts_with($name, 'app_')) {
                $routeChoices[$name] = $name;
            }
        }

        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tutorial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tutorial/edit.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form,
            'routes' => $routeChoices,
        ]);
    }

    #[Route('/{id}', name: 'app_tutorial_delete', methods: ['POST'])]
    public function delete(Request $request, Tutorial $tutorial, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tutorial->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tutorial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tutorial_index', [], Response::HTTP_SEE_OTHER);
    }
}
