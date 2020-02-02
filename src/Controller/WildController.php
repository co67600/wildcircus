<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Entity\Tournee;
use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/", name="wild")
     */
    public function index()
    {
        $artiste = $this ->getDoctrine()->getRepository(Artiste::class)->findAll();
        $tournee = $this ->getDoctrine()->getRepository(Tournee::class)->findAll();
        return $this->render('wild/index.html.twig', [
            'controller_name' => 'WildController',
            'artiste' => $artiste,
            'tournee' => $tournee,
        ]);
    }

}
