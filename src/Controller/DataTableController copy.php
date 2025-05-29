<?php

namespace App\Controller;

use App\Form\DataRequestType;
use App\Form\DataTableType;
use App\Service\DataSourceRegistry;
use App\Service\DataTableFactory;
use App\Service\DataTablePresenter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataTableController extends AbstractController
{
    #[Route('/manage-data', name: 'app_manage_data')]
    public function manageData(
        Request $request,
        DataSourceRegistry $registry,
        DataTableFactory $DataTableFactory,
        DataTablePresenter $DataTablePresenter,
        EntityManagerInterface $em
    ): Response {
        // 1) On détermine la source
        $source = $request->query->get('source', 'odata');

        // 2) Formulaire unifié pour tous les types de sources
        //    (il contiendra les champs url, username, password, etc. selon la source)
        $form = $this->createForm(DataRequestType::class, ['source' => $source]);
        $form->handleRequest($request);

        $data     = null;
        $table    = null;
        $tableForm = null;

        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Récupère les paramètres du formulaire (url, credentials, fichier…)
            $params = $form->getData();

            // 4) On récupère le handler adapté (OData, SOAP, File…)
            $handler = $registry->get($params['source']);

            // 5) On appelle le handler pour obtenir un tableau homogène
            $data = $handler->handle($params);

            // 6) On construit l’entité Table
            $table = $DataTableFactory->createFromArray($data, $params['source']);

            // 7) On prépare le formulaire d’édition de la Table
            $tableForm = $this->createForm(DataTableType::class, $table);
            $tableForm->handleRequest($request);

            // 8) Persistance si on valide le tableau
            if ($tableForm->isSubmitted() && $tableForm->isValid()) {
                $em->persist($tableForm->getData());
                $em->flush();
                $this->addFlash('success', 'Table enregistrée avec succès');

                return $this->redirectToRoute('app_manage_data', ['source' => $params['source']]);
            }
        }

        // 9) Préparation des données pour la vue
        $presented = $table
            ? $DataTablePresenter->toTwigModel($table)
            : ['headers' => [], 'matrix' => []];

        return $this->render('manage_data/manage_data.html.twig', [
            'form'       => $form->createView(),
            'tableForm'  => $tableForm?->createView(),
            'data'       => $data,
            'source'     => $source,
            'headers'    => $presented['headers'],
            'matrix'     => $presented['matrix'],
            'error'      => $error ?? null,
        ]);
    }

}
