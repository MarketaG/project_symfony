<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\User;
use AppBundle\Form\ReservationType;


/**
 * @Route("/reservation")
 */
class ManageReservationController extends Controller
{
    /**
     * @Route("/new/{id}", name="newReservation")
     */
    public function newReservationAction(Request $request,$id=null)
    {
        if($id)
        {   $repository = $this->getDoctrine()->getRepository(Reservation::class);
            $reservation = $repository->find($id);
        }else{
            $reservation = new Reservation();
        }
        //Form compilation
        $form = $this->createForm(ReservationType::class, $reservation);
        //
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $this->getUser();
            $reservation->setUser($user);
            //
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('reservation');
        }
        // replace this example code with whatever you need
        return $this->render('manageTapas/newReservation.html.twig',array('form'=>$form->createView()));
    }


    /**
     * @Route("/reservation", name="reservation")
     */
    public function reservationAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $reservation = $repository->findByUser($this->getUser());
        // replace this example code with whatever you need
        return $this->render('manageTapas/reservation.html.twig',array("reservation" => $reservation));
    }
    /**
     * @Route("/delete/{id}", name="deleteReservation")
     */
    public function deleteReservationAction(Request $request,$id=null)
    {
        if($id)
        {
            //
            $repository = $this->getDoctrine()->getRepository(Reservation::class);
            $reservation = $repository->find($id);
            //
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }
        return $this->redirectToRoute('reservation');
    }
}