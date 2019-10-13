<?php

namespace App\Controller\Admin;

use App\Entity\Boat;
use App\Form\BoatType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BoatRepository;

class AdminBoatController extends AbstractController
{
    public function __construct(BoatRepository $br, ObjectManager $em)
    {
        $this->repo = $br;
        $this->em = $em;
    }

    /**
     * @Route("boat/new", name="admin.boat.new")
     */
    public function new(Request $request)
    {
        $boat = new Boat();
        $boat->setCreatedBy($this->getUser());
        $form = $this->createForm(BoatType::class, $boat);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($boat);
            $this->em->flush();
            $this->addFlash("success", "Boat '".$boat->getName()."' correctly added");
            return $this->redirectToRoute('boat.list');
        }

        return $this->render('boat/admin/new.html.twig', [
            'boat' => $boat,
            'title' => 'Create a new Boat',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("boat/{id}", name="admin.boat.edit")
     */
    public function edit(Boat $boat, Request $request)
    {
        $form = $this->createForm(BoatType::class, $boat);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash("success", "Boat '".$boat->getName()."' correctly updated");
            return $this->redirectToRoute('boat.list');
        }

        return $this->render('boat/admin/edit.html.twig', [
            'boat' => $boat,
            'title' => 'Create a new Boat',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("boat/{id}/delete", name="admin.boat.delete")
     */
    public function delete(Boat $boat, Request $request)
    {
        if($this->isCsrfTokenValid('deleteBoat'.$boat->getId(), $request->get('_token'))){
            $this->em->remove($boat);
            $this->em->flush();
            $this->addFlash("success", "Boat '".$boat->getName()."' correctly deleted");
        }

        return $this->redirectToRoute('boat.list');
    }
}
