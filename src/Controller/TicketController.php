<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket/{name}/{la9ab}", name="ticket")
     */
    public function index($name, $la9ab): Response
    {
        return $this->render('ticket/index.html.twig', [
           'esm' => $name,
           'la9ab' => $la9ab,
        ]);
    }

    /**
     * @Route("/request", name="request")
     */
    public function showRequest(Request $request) {
        dd($request);
    }
}
