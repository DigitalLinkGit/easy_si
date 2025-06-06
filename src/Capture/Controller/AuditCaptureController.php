<?php

namespace App\Capture\Controller;

use App\Capture\Entity\AuditCapture;
use App\Capture\Entity\AuditLine;
use App\Capture\Form\AuditCaptureType;
use App\Capture\Repository\AuditCaptureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/audit-capture')]
class AuditCaptureController extends AbstractController
{
    #[Route('/', name: 'app_audit_capture_index', methods: ['GET'])]
    public function index(AuditCaptureRepository $repository): Response
    {
        return $this->render('capture/compose/audit-capture/index.html.twig', [
            'captures' => $repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_audit_capture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        
        $types = [
            'CRM',
            'Facturation',
            'Support',
            'Gestion projet',
            'Marketing',
            'RH / Paie',
            'BI / Reporting',
            'E-commerce',
            'ERP',
            'Mail',
        ];

        $capture = new AuditCapture();

        foreach ($types as $type) {
            $line = new AuditLine();
            $line->setType($type);
            $capture->addLine($line);
        }

        $form = $this->createForm(AuditCaptureType::class, $capture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($capture);
            $em->flush();

            return $this->redirectToRoute('app_audit_capture_index');
        }

        return $this->render('capture/compose/audit-capture/new.html.twig', [
            'form' => $form,
            'lines' => $capture->getLines(),
        ]);
    }
}
