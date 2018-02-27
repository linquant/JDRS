<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Roleplay;

class RoleplayController extends Controller
{
    /**
     * @Route("/roleplay", name="roleplay")
     */
    public function index()
    {


    }

    public function create_roleplay($story){

        $em = $this->getDoctrine()->getManager();

        $Roleplay = new Roleplay();
        $Roleplay->setStory($story);
        $Roleplay->setUser($this->getUser());


        // tell Doctrine you want to (eventually) save the Roleplay (no queries yet)
        $em->persist($Roleplay);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return $Roleplay->getId();


    }
    public function read_roleplay($id){


        $Roleplay = $this->getDoctrine()
            ->getRepository(Roleplay::class)
            ->find($id);

        if (!$Roleplay) {
            throw $this->createNotFoundException(
                'No Roleplay found for id ' . $id
            );


        }
        return $Roleplay;
    }
    public function update_roleplay($id,$story){


        $em = $this->getDoctrine()->getManager();
        $Roleplay = $em->getRepository(Roleplay::class)->find($id);

        if (!$Roleplay) {
            throw $this->createNotFoundException(
                'No Roleplay found for id '.$id
            );
        }

        $Roleplay->setstory($story);
        $em->flush();

        return $id;

    }

    public function delete_roleplay($id){

        $em = $this->getDoctrine()->getManager();
        $Roleplay = $em->getRepository(Roleplay::class)->find($id);

        if (!$Roleplay) {
            throw $this->createNotFoundException(
                'No Roleplay found for id '.$id
            );
        }


        $em->remove($Roleplay);
        $em->flush();

    }


    public function save($story, $id = null){

        if($id == null){

            return $this->create_roleplay($story);
        }
        else{

           return  $this->update_roleplay($id,$story);
        }

    }

}
