<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use AppBundle\Entity\Tapa;
use AppBundle\Entity\Category;
use AppBundle\Entity\User;

use AppBundle\Form\UserType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $tapaRepository = $this->getDoctrine()->getRepository(Tapa::class);
        $tapas = $tapaRepository->findAll();
        // replace this example code with whatever you need
        return $this->render('frontal/index.html.twig', array('tapas'=>$tapas));
    }
    /**
     * @Route("/aboutus", name="aboutus")
     */
    public function aboutusAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('frontal/aboutus.html.twig');
    }
    /**
     * @Route("/contact/{place}", name="contact")
     */
    public function contactAction(Request $request,$place="all")
    {
        // replace this example code with whatever you need
        return $this->render('frontal/restaurant.html.twig',array("place"=>$place));
    }
    /**
     * @Route("/tapa/{id}", name="tapa")
     */
    public function tapaAction(Request $request,$id=null)
    {
        if($id!=null){
            $tapaRepository = $this->getDoctrine()->getRepository(Tapa::class);
            $tapa = $tapaRepository->find($id);
            return $this->render('frontal/foods.html.twig',array("tapa"=>$tapa));
        }else{
            return $this->redirectToRoute('homepage');
        }
    }
    /**
     * @Route("/category/{id}", name="category")
     */
    public function catAction(Request $request,$id=null)
    {
        if($id!=null){
            $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
            $category = $categoryRepository->find($id);
            return $this->render('frontal/category.html.twig',array("category"=>$category));
        }else{
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        //Form compilation
        $form = $this->createForm(UserType::class, $user);
        //
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            //3b) $username=$email
            $user->setUsername($user->getEmail());

            //3c) roles

            $user->setRoles(array('ROLE_USER'));


            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('login');
        }
        // replace this example code with whatever you need
        return $this->render('frontal/register.html.twig',array('form' => $form->createView()));
    }

    /**
     * @Route("/login", name="login")
     */
    public function LoginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('frontal/login.html.twig', array(
                'last_username' => $lastUsername,
                'error'         => $error,
                ));
    }

}
