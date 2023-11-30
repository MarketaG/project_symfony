<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\TapaType;
use AppBundle\Entity\Tapa;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;


/**
 * @Route("/manageTapa")
 */
class ManageTapasController extends Controller
{
    /**
     * @Route("/newTapa", name="newTapa")
     */
    public function newTapaAction(Request $request)
    {
        $tapa = new Tapa();
        //Form compilation
        $form = $this->createForm(TapaType::class, $tapa);
        //
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $tapa = $form->getData();
            $fotoFile=$tapa->getFoto();
            $fileName = $this->generateUniqueFileName().'.'.$fotoFile->guessExtension();
            $fotoFile->move(
                $this->getParameter('tapaImg_directory'),
                $fileName
            );
            $tapa->setFoto("$fileName");
            $tapa->setCreationDate(new \DateTime());
            //
            $em = $this->getDoctrine()->getManager();
            $em->persist($tapa);
            $em->flush();
            return $this->redirectToRoute('tapa',array('id'=> $tapa->getId()));
        }
        // replace this example code with whatever you need
        return $this->render('manageTapas/newTapa.html.twig',array('form' => $form->createView()));
    }


    /**
     * @Route("/newCategory", name="newCategory")
     */
    public function newCatAction(Request $request)
    {
        $category = new Category();
        //Form compilation
        $form = $this->createForm(CategoryType::class, $category);
        //
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $category = $form->getData();
            $fotoFile=$category->getFoto();
            $fileName = $this->generateUniqueFileName().'.'.$fotoFile->guessExtension();
            $fotoFile->move(
                $this->getParameter('tapaImg_directory'),
                $fileName
            );
            $category->setFoto("$fileName");
            //
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category',array('id'=> $category->getId()));
        }
        // replace this example code with whatever you need
        return $this->render('manageTapas/newCategory.html.twig',array('form' => $form->createView()));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

}