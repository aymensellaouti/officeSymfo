<?php

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TodoDBController
 * @package App\Controller
 * @Route("/tododb")
 */
class TodoDBController extends AbstractController
{
    /**
     * @Route("/add/{name}/{description}", name="tododb.add")
     */
    public function addDbTodo($name, $description): Response
    {
        //Création de l'objet
        $todo = new Todo();
        $todo->setName($name)
             ->setDescription($description);
        $todo2 = new Todo();
        $todo2->setName($name.' second');
        $todo2->setDescription($description.' second');
        //Récupération du manager de Doctrine
        $manager = $this->getDoctrine()->getManager();

        $manager->persist($todo);
        $manager->persist($todo2);

        $manager->flush();


        return $this->redirectToRoute('tododb.list');
    }

    /**
     * @Route("/list/{page?1}/{nbre?8}", name= "tododb.list")
     */
    public function showAlltodos($page, $nbre) {

        $repository = $this->getDoctrine()->getRepository(Todo::class);
        dd($repository->getAllTodosByStatus(['En Cours', 'Annulée']));
        $nbreTodo = $repository->count([]);
        $todos = $repository->findBy(
            [],
            [],
            $nbre,
            ($page - 1) * $nbre
        );

        $nbrePage = ($nbreTodo%$nbre === 0)?$nbreTodo / $nbre : ceil($nbreTodo / $nbre) ;
//        $previous = ($page == 1)? $page : $page - 1;
//        $next = ($page == $nbrePage)? $page : $page + 1;
        return $this->render('todo_db/index.html.twig', [
            'todos' => $todos,
            'nbrePages' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre,
//            'previous' => $previous,
//            'next' => $next
            ]);
    }

    /**
     * @Route("/delete/{id}", name= "tododb.delete")
     */
    public function deleteTodo($id) {
        $repository = $this->getDoctrine()->getRepository(Todo::class);
        $todo = $repository->find($id);
        if ($todo) {
            // je le supprime
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($todo);
            $manager->flush();
        } else {
            // flashmessage
            $this->addFlash('error', 'Le todo que vous voulez supprimer est innexistant');
        }
        return $this->redirectToRoute('tododb.list');
    }
}
