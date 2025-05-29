<?php
// src/Controller/TestController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProposalRepository;
use App\Repository\SectionRepository;
use App\Repository\QuestionInstanceRepository;
use App\Service\RequestService;
use App\Service\DataSourceRegistry;

class TestController extends AbstractController
{
    #[Route('/test/graph', name: 'app_test_graph')]
    public function graph(): Response
    {
        return $this->render('test/graph.html.twig');
    }
    #[Route('/test/countp/{sectionId}/{level}', name: 'app_test_countp')]
    public function testCountProposalsForSingleChoiceAtLevel(
        QuestionInstanceRepository $qiRepo,
        SectionRepository $sectionRepo,
        int $sectionId,
        int $level
    ): Response {
        $section = $sectionRepo->find($sectionId);

        if (!$section) {
            throw $this->createNotFoundException("Section not found.");
        }

        $count = $qiRepo->countProposalsForSingleChoiceAtLevelInSection($level, $section->getId());

        dd([
            'section' => $section->getName(),
            'level' => $level,
            'nbProposals' => $count
        ]);
    }


    #[Route('/test/countq/{sectionId}/{level}', name: 'app_test_countq')]
    public function testCountQuestionsByLevel(
        QuestionInstanceRepository $qiRepo,
        SectionRepository $sectionRepo,
        int $sectionId,
        int $level
    ): Response {
        $section = $sectionRepo->find($sectionId);

        $count = $qiRepo->countByLevel($level, $section->getId());

        dd([
            'section' => $section->getName(),
            'level' => $level,
            'nbQuestions' => $count
        ]);
    }

    #[Route('/test-handler', name: 'app_test_handler')]
    public function testHandler(\App\Service\DataHandler\OdataHandler $handler): Response
    {
        //$url = 'https://my428951.businessbydesign.cloud.sap/sap/byd/odata/cust/v1/staging_order/BusinessPartnerToAccountCollection?$top=1';
        $url = 'https://my428951.businessbydesign.cloud.sap/sap/byd/odata/cust/v1/staging_order/$metadata';
        $username = '_APSIADEV';
        $password = 'Dev4Apsia';

        $results = $handler->handle([
            'url' => $url,
            'username' => $username,
            'password' => $password,
        ]);

        return new Response('<pre>' . htmlspecialchars(json_encode($results, JSON_PRETTY_PRINT)) . '</pre>');
    }
    #[Route('/test-request', name: 'app_test_request')]
    public function testRequest(RequestService $requestService): Response
    {
        $url = 'https://my428951.businessbydesign.cloud.sap/sap/byd/odata/cust/v1/staging_order/BusinessPartnerToAccountCollection?$top=1';
        $username = '_APSIADEV';
        $password = 'Dev4Apsia';

         try {
             $data = $requestService->fetch($url, [
                 'auth_basic' => [$username, $password],
                 'headers' => [
                     'Accept' => 'application/json, application/xml;q=0.9, */*;q=0.8',
                 ],
             ]);

            return new Response(
                '<pre>' . (is_array($data) ? json_encode($data, JSON_PRETTY_PRINT) : htmlspecialchars((string)$data)) . '</pre>'
            );
        } catch (\Throwable $e) {
            return new Response('Erreur : ' . $e->getMessage(), 500);
        }
    }
    #[Route('/test-registry', name: 'app_test_registry')]
    public function testRegistry(DataSourceRegistry $registry): Response
    {
        $handler = $registry->get('odata');
        return new Response(get_class($handler));
    }
}
