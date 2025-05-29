<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transformation')]
class TransformationController extends AbstractController
{
    #[Route('/', name: 'app_transformation_index')]
    public function index(): Response
    {
        return new Response('TransformationController index placeholder');
    }
}
