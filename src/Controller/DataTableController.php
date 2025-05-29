<?php

namespace App\Controller;

use App\Entity\Interaction;
use App\Entity\DataTable;
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

#[Route('/datatable')]
class DataTableController extends AbstractController
{

    #[Route('/new', name: 'app_datatable_new')]
    public function new(
        Request $request,
        DataSourceRegistry $registry,
        DataTableFactory $tableFactory,
        DataTablePresenter $tablePresenter,
        EntityManagerInterface $em
    ): Response {
        $source = $request->query->get('source', 'odata');
        $interactionId = $request->query->get('interaction');
        $dataRole = $request->query->get('role'); // 'in' ou 'out'

        $form = $this->createForm(DataRequestType::class, ['source' => $source]);
        $form->handleRequest($request);

        $data = null;
        $table = null;
        $tableForm = null;
        $interaction = null;
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();

            try {
                $handler = $registry->get($params['source']);
                $data = $handler->handle($params);

                $table = $tableFactory->createFromArray($data, $params['source']);
                $tableForm = $this->createForm(DataTableType::class, $table);
                $tableForm->handleRequest($request);

                if ($tableForm->isSubmitted() && $tableForm->isValid()) {
                    $table = $tableForm->getData();
                    $em->persist($table);

                    if ($interactionId && $dataRole) {
                        $interaction = $em->getRepository(Interaction::class)->find($interactionId);
                        if ($interaction) {
                            if ($dataRole === 'in') {
                                $interaction->addTablesIn($table);
                            } elseif ($dataRole === 'out') {
                                $interaction->setTableOut($table);
                            }
                            $em->persist($interaction);
                        }
                    }

                    $em->flush();
                    $this->addFlash('success', 'Table enregistrée et liée avec succès');

                    return $this->redirectToRoute('app_interaction_edit', [
                        'id' => $interactionId,
                        '#' => ($dataRole === 'in' ? 'input-tables' : 'output-table')
                    ]);
                }
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }
        }

        $presented = $table
            ? $tablePresenter->toTwigModel($table)
            : ['headers' => [], 'matrix' => []];

        return $this->render('datatable/new.html.twig', [
            'form'       => $form->createView(),
            'tableForm'  => $tableForm?->createView(),
            'data'       => $data,
            'source'     => $source,
            'headers'    => $presented['headers'],
            'matrix'     => $presented['matrix'],
            'interactionId' => $interactionId,
            'dataRole'      => $dataRole,
            'error'         => $error,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_datatable_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        DataTable $dataTable,
        DataTablePresenter $tablePresenter,
        EntityManagerInterface $em
    ): Response {
        $interactionId = $request->query->get('interaction');
        $dataRole = $request->query->get('role'); // 'in' ou 'out'

        $tableForm = $this->createForm(DataTableType::class, $dataTable);
        $tableForm->handleRequest($request);

        if ($tableForm->isSubmitted() && $tableForm->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Table modifiée avec succès');

            return $interactionId
                ? $this->redirectToRoute('app_interaction_edit', [
                    'id' => $interactionId,
                    '#' => ($dataRole === 'in' ? 'input-tables' : 'output-table'),
                ])
                : $this->redirectToRoute('app_dataTable_index');
        }

        $presented = $tablePresenter->toTwigModel($dataTable);

        return $this->render('datatable/edit.html.twig', [
            'tableForm' => $tableForm->createView(),
            'headers'   => $presented['headers'],
            'matrix'    => $presented['matrix'],
            'interactionId' => $interactionId,
            'dataRole'      => $dataRole,
        ]);
    }



    #[Route('/select/{dataTable}/{interaction}/{role}', name: 'app_datatable_select')]
    public function select(DataTable $dataTable, Interaction $interaction, string $role, EntityManagerInterface $em): Response
    {
        if ($role === 'in') {
            $interaction->addTablesIn($dataTable);
        } elseif ($role === 'out') {
            $interaction->setTableOut($dataTable);
        }
        $em->persist($interaction);
        $em->flush();

        return $this->redirectToRoute('app_interaction_edit', [
            'id' => $interaction->getId(),
            '#' => ($role === 'in' ? 'input-tables' : 'output-table')
        ]);
    }
    #[Route('/', name: 'app_datatable_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $interactionId = $request->query->get('interaction');
        $dataRole = $request->query->get('role'); // 'in' ou 'out'

        $dataTable = $em->getRepository(DataTable::class)->findBy([], ['id' => 'DESC']);

        return $this->render('datatable/index.html.twig', [
            'dataTable' => $dataTable,
            'interactionId' => $interactionId,
            'dataRole' => $dataRole,
        ]);
    }
}
