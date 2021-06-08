<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    public function index(SessionInterface $session): Response
    {
        // Je vérifie si j'ai la liste dans la session
        if (!$session->has('todos')) {
            $todos = array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $session->set('todos', $todos);
            $this->addFlash('info', 'La liste des todos a été initialisée avec succées');
        }
        return $this->render('todo/index.html.twig');
    }

    /**
     * @Route("/todo/add/{name}/{description}", name="todo.add")
     */
    public function addTodo(SessionInterface $session, $name, $description) {
        // Je vérifie si la session existe
        // si oui
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            // je vérifie s'il existe un todo de la même clé
            if (isset($todos[$name])) {
                // si oui
                // message erreur
                $this->addFlash('error', "Le todo de clé $name existe déjà");
            } else {
                // si non
                // on l'ajoute + message success
                $todos[$name] = $description;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo de clé $name a été ajouté avec succès");
            }
        // si non
        } else {
            $this->addFlash('error', "La session n'est pas encore initialisée");
        }
        return $this->redirectToRoute('todo');
    }
}
