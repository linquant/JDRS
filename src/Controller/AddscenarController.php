<?php
/**
 * Created by PhpStorm.
 * User: johann
 * Date: 21/02/18
 * Time: 21:10
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\Action;
use App\Form\ActionType;

use App\Entity\Sujet;
use App\Form\SujetType;


class AddscenarController extends Controller
{

    public function addscenar($type, Request $request){


        //si erreur dans le paramétre routage vers la home du site
        if($type != 'sujet' AND $type != 'action'){

            return $this->redirectToRoute('app_home');

        }


        if($type == 'action'){
                        
            // formulaire pour ajouter des actions au générateur de scénar
            $form = $this->createForm(Actiontype::class, new Action());
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {

                 $reponse = $form->getData();

                 $entry =$reponse->getaction();
               
                $action = new Action();
                $action->setAction($entry);

                $em = $this->getDoctrine()->getManager();
                $em->persist($action);
                $em->flush();

             }
            
                                            
          }                                 
          elseif ($type =='sujet'){


              // formulaire pour ajouter des sujets au générateur de scénar
              $form = $this->createForm(SujetType::class, new Sujet());
              $form->handleRequest($request);

              if ($form->isSubmitted() && $form->isValid()) {


                  $reponse = $form->getData();

                  $entry =$reponse->getsujet();

                  $sujet = new sujet();
                  $sujet->setsujet($entry);

                  $em = $this->getDoctrine()->getManager();
                  $em->persist($sujet);
                  $em->flush();

              }
                                            
          }
        else{
            return $this->redirectToRoute('app_home');
        }
                                            
            


        return $this->render('admin/addscenar.html.twig',
            array(
                'form' => $form->createView(),
                'type' => $type,
                'list_keyword' =>  $this->getkeywordscenar($type),
            ));

    }


    /**
     * @param $type
     * @return array
     */
    public function getkeywordscenar($type){

        if($type!= 'sujet' AND $type != 'action'){
             return $this->redirectToRoute('app_home');
        }
        //Création de la méthode dynamiquement
        $DynamicMethode = "get".$type;
        //Création du chemin d'acces à la class dynamiquement
        $type = "App\\Entity\\".(string)ucfirst($type);


        //appel du repository dynamiquement
        $repository = $this->getDoctrine()->getRepository(get_class(new $type()));

        $content = $repository->findAll();

        //On met au propre dans un tableau pour envoyer à twig
        $output = array();

        foreach ($content as $index => $item) {
          $output[$index] = $item-> $DynamicMethode();

        }

        return $output;

    }



}