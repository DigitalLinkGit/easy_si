<?php

namespace App\Controller;

use App\Entity\Element;
use App\Form\ElementType;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Form\ServiceMinimalType;
use App\Service\UploadHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/element')]
final class ElementController extends AbstractController
{
    #[Route(name: 'app_element_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $elements = $entityManager
            ->getRepository(Element::class)
            ->findAll();

        return $this->render('element/index.html.twig', [
            'elements' => $elements,
        ]);
    }

    #[Route('/new', name: 'app_element_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UploadHelper $uploadHelper, EntityManagerInterface $entityManager): Response
    {
        $element = new Element();
        $form = $this->createForm(ElementType::class, $element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logo')->getData();
            $oldLogo = $element->getLogo();

            $newFilename = $uploadHelper->handleLogoUpload($logoFile, $oldLogo);
            $element->setLogo($newFilename);

            $entityManager->persist($element);
            $entityManager->flush();

            return $this->redirectToRoute('app_element_edit', ['id' => $element->getId()], Response::HTTP_SEE_OTHER);
        }

        $service = new Service();
        $service->setElement($element); // pour pré-remplir
        $serviceForm = $this->createForm(ServiceType::class, $service);
        return $this->render('element/new.html.twig', [
            'element' => $element,
            'form' => $form,
            'serviceForm' => $serviceForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_element_show', methods: ['GET'])]
    public function show(Element $element): Response
    {
        return $this->render('element/show.html.twig', [
            'element' => $element,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_element_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Element $element, EntityManagerInterface $em, UploadHelper $uploadHelper): Response
    {
        $form = $this->createForm(ElementType::class, $element);
        $form->handleRequest($request);


        // Formulaire modal
        $service = new Service();
        $service->setElement($element);
        $serviceForm = $this->createForm(ServiceMinimalType::class, new Service(), [
            'action' => $this->generateUrl('app_element_add_service', ['id' => $element->getId()]),
            'method' => 'POST',
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logo')->getData();
            $oldLogo = $element->getLogo();
            $newFilename = $uploadHelper->handleLogoUpload($logoFile, $oldLogo);
            $element->setLogo($newFilename);

            $em->flush();

            $this->addFlash('success', 'Élément modifié avec succès.');
            return $this->redirectToRoute('app_element_edit', ['id' => $element->getId()]);
        }

        return $this->render('element/edit.html.twig', [
            'element' => $element,
            'form' => $form->createView(),
            'serviceForm' => $serviceForm->createView(),
        ]);
    }

    #[Route('/{id}/add-service', name: 'app_element_add_service', methods: ['POST'])]
    public function addService(Request $request, Element $element, EntityManagerInterface $em): Response
    {
        $service = new Service();
        $service->setElement($element);

        $form = $this->createForm(ServiceMinimalType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($service);
            $em->flush();

            $this->addFlash('success', 'Service ajouté avec succès.');
        } else {
            $this->addFlash('danger', 'Erreur lors de l’ajout du service.');
            /*
            dump($request->request->all());
            dump($request->request->get('_token'));
            dump($form->getName()); // ← nom racine
            dump($form->getData());
            die();
            */
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('danger', $error->getMessage());
            }
        }

        return $this->redirectToRoute('app_element_edit', ['id' => $element->getId()]);
    }

    #[Route('/{id}', name: 'app_element_delete', methods: ['POST'])]
    public function delete(Request $request, Element $element, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $element->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($element);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_element_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/service/{id}/delete', name: 'app_element_delete_service', methods: ['POST'])]
    public function deleteService(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_service_' . $service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();

            $this->addFlash('success', 'Service supprimé avec succès.');
        } else {
            $this->addFlash('danger', 'Échec de la suppression du service (CSRF).');
        }

        return $this->redirectToRoute('app_element_edit', [
            'id' => $service->getElement()?->getId()
        ]);
    }
}
