<?php


namespace App\Controller;


use App\Model\Personne;
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
     * @Route("/cv/{name}/{firstname}/{age<[-]?\d{1,2}>}/{section<GL|RT>?GL}", name="cv")
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

    /**
     * @Route("/randomtab/{nbre<\d{1,2}>?5}")
     */
    public function showRandomTab($nbre) {
        $notes = [];
        for ($i=0; $i < $nbre; $i++) {
            $notes[$i] = rand(0,20);
        }
        return $this->render('tab/randomTab.html.twig', ['notes' => $notes]);
    }
    /**
     * @Route("/heritage")
     */
    public function heritage() {
        return $this->render('fils.html.twig');
    }

    /**
     * @Route("/inclusion")
     */
    public function inclusion() {

        $personnes = [
            $this->convertObjectToTab(new Personne('houda', 'houda', 25)),
            $this->convertObjectToTab(new Personne('aymen', 'aymen', 35)),
            $this->convertObjectToTab(new Personne('wassef', 'wassef', 45)),
        ];
        return $this->render('inclusion.html.twig', [
            'personnes' => $personnes
        ]);
    }

    private function convertObjectToTab($objet): array {
        $newArray = [];
        foreach ($objet as $key => $value ){
            $newArray[$key] = $value;
        }
        return $newArray;
    }
}