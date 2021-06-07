<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{

    /**
     * @Route("/first", name="first")
     */
    public function sayHello() {
        return new Response("<h1>Hello Forma :)</h1>");
    }

    /**
     * @Route("/cv/{name}/{firstname}/{age}/{section}", name="cv")
     */
    public function cv($name, $firstname, $age, $section) {
        return $this->render('cv/cv.html.twig', [
            'name' => $name,
            'firstname' => $firstname,
            'age' => $age,
            'section' => $section,
        ]);
    }

    /**
     * @Route("session", name="session.example")
     */
    public function counter(SessionInterface $session): Response
    {
        if ($session->has('nbreVisite')) {
            $nbre = $session->get('nbreVisite');
            $nbre++;
            $session->set('nbreVisite', $nbre);
        } else {
            $this->addFlash('success', 'je suis un message qui dure une fois');
            $session->set('nbreVisite', 1);
        }
        return $this->render('session/index.html.twig');
    }

}