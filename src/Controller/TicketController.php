<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Ticket;
use App\Form\TicketType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        $criteria = [];
        if (in_array('ROLE_CLIENT',$this->getUser()->getRoles())) {
            $criteria = ['owner' => $this->getUser()];
        }

        $nbreTickets = $repository->count($criteria);
        $tickets = $repository->findBy(
            $criteria,
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
     * @IsGranted("ROLE_CLIENT")
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
     * @IsGranted("ROLE_CLIENT")
     * @Route("/add/process", name="ticket.add.process")
     */
    public function processAddTicket(Request $request, SluggerInterface $slugger, LoggerInterface $logger) {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->remove('status');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // ajouter le ticket dans la base de données
            $file = $form->get('uplaodedFichier')->getData();
            if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('ticket_directory'),
                    $newFilename
                );
                $logger->info('File loaded successfuly');
            } catch (FileException $e) {
                $logger->critical('File load fail');
               dd("erreur d'upload");
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $ticket->setFichier($newFilename);
            }

            if (!$ticket->getId()) {

                $status = $this->getDoctrine()->getRepository(Status::class)->findOneBy(
                    ['description' => Status::DEFAULT_STATUS]
                );
                $ticket->setStatus($status);
                $ticket->setOwner($this->getUser());
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
