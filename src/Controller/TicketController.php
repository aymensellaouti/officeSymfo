<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TicketController
 * @package App\Controller
 * @Route("ticket")
 */
class TicketController extends AbstractController
{
    /**
     * @Route("/", name="ticket")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Ticket::class);
        $tickets = $repository->findAll();
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets
        ]);
    }

    /**
     * @Route("/add", name="ticket.add")
     */
    public function addTicket(): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        return $this->render('ticket/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
