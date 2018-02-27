<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class SecurityController extends Controller
{

    public function login(Request $request, AuthenticationUtils $authUtils)
    {

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

    }

    public function sign(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $user = new User();
        $form = $this->createForm(UserType::class,$user);


        //récupéartion des doonées du formulaire


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            $flashbag = $this->get('session')->getFlashBag();
            $flashbag->add('notice', 'Votre inscription est terminée');

            return $this->redirectToRoute('app_home');
        }




        return $this->render('sign.html.twig', array('form' => $form->createView()));

    }

}