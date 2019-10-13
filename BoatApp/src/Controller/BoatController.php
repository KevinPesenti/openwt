<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BoatRepository;

class BoatController extends AbstractController
{
    /**
     * @Route("/", name="boat.list")
     */
    public function boatList(BoatRepository $br)
    {
    	$boats = $br->findAll();

        return $this->render('boat/list.html.twig', [
            'boats' => $boats,
        ]);
    }
}
