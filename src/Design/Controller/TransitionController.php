<?php

namespace App\Design\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transition')]
class TransitionController extends AbstractController
{
    #[Route('/', name: 'app_transition_index')]
    public function index(): Response
    {
        return new Response('TransitionController index placeholder');
    }
}
