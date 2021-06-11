<?php

namespace App\Controller;

use App\Entity\Status;
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
     * @Route("/{page<\d+>?1}/{nbre<\d+>?8}", name="ticket")
     */
    public function index($page, $nbre): Response
    {
        $repository = $this->getDoctrine()->getRepository(Ticket::class);
        $nbreTickets = $repository->count([]);
        $tickets = $repository->findBy(
            [],
            ['updatedAt' => 'desc'],
            $nbre,
            ($page - 1) * $nbre
        );
        $nbrePage = ($nbreTickets % $nbre === 0)? $nbreTickets / $nbre : ceil($nbreTickets / $nbre) ;
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
            'nbrePages' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre,
        ]);
    }

    /**
     * @Route("/add/{id<\d+>?0}", name="ticket.add")
     */
    public function addTicket(Ticket $ticket = null): Response
    {
        if ($ticket == null) {
            $ticket = new Ticket();
        }

        $form = $this->createForm(TicketType::class, $ticket, [
            'action' => $this->generateUrl('ticket.add.process')
        ]);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->remove('status');

        return $this->render('ticket/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add/process", name="ticket.add.process")
     */
    public function processAddTicket(Request $request) {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // ajouter le ticket dans la base de données
            if (!$ticket->getId()) {
                $status = $this->getDoctrine()->getRepository(Status::class)->findOneBy(
                    ['description' => Status::DEFAULT_STATUS]
                );
                $ticket->setStatus($status);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ticket);

            $manager->flush();

            return $this->redirectToRoute('ticket');
        }
        return $this->render('ticket/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
