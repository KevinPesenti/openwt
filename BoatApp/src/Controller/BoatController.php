<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BoatRepository;

class BoatController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
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
