<?php

namespace App\Controller;

use App\Entity\Sujet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SujetRepository;



class SujetController extends Controller
{
    /**
     * @Route("/sujet", name="sujet")
     */
    public function index()
    {
       
    }

    public function create_sujet($sujet){

        $em = $this->getDoctrine()->getManager();

        $Sujet = new Roleplay();
        $Sujet->setSujet($sujet);


        // tell Doctrine you want to (eventually) save the Roleplay (no queries yet)
        $em->persist($Sujet);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        

    }

    public function read_sujet($id){


        $Sujet = $this->getDoctrine()
            ->getRepository(Sujet::class)
            ->find($id);

        if (!$Sujet) {
            throw $this->createNotFoundException(
                'No Sujet found for id ' . $id
            );


        }
        return $Sujet;
    }


}
