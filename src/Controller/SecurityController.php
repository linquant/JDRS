<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

use App\Form\UserType;


class SecurityController extends Controller
{

    public function login(Request $request, AuthenticationUtils $authUtils)
    {

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('admin/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

    }

    public function sign(Request $request){

        //Génération du formulaire de création de compte
        $form = $this->createForm(UserType::class, new User());


        //récupéartion des doonées du formulaire

       // $form->handleRequest($request);



        return $this->render('sign.html.twig', array('form' => $form->createView()));

    }

}