<?php
/**
 * Created by PhpStorm.
 * User: johann
 * Date: 28/02/18
 * Time: 11:35
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Sujet;
use App\Entity\Action;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImportController extends Controller
{

  
    public function import(){

        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
            ->add('Fichier', FileType::class ,array('label' => 'Fichier (CSV file)'))
            ->add('liste', ChoiceType::class, array(
            'choices' => array(
                'Action' => 'Action',
                'Sujet' => 'Sujet',
            ),))
            ->add('Send', SubmitType::class)
            ->getForm()->createView();


//        if ($form->isSubmitted() && $form->isValid()) {
//            // data is an array with "name", "email", and "message" keys
//            $data = $form->getData();
//        }


        return $this->render('import.html.twig',array('form' => $form));
    }

    public function open(){

//TODO Mettre le nom du fichier en paramétre de méthode

   $donnee = array();

        if (($handle = fopen("test.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

              array_push($donnee, $data);

            }
            fclose($handle);
        }





        $this->write_db('sujet',$donnee);

        return $donnee;
        
    }


    public function write_db($nom_entité, $donnee){


        if ($nom_entité != 'sujet' AND $nom_entité != 'action'){

            throw $this->createNotFoundException(
                'Erreur entité inconnue'
            );
        }

        //Contruction Dynamiques
        $DynamicMethode = "set".$nom_entité;
        $nom_entité = "App\\Entity\\".(string)ucfirst($nom_entité);


        $em = $this->getDoctrine()->getManager();

        foreach ($donnee as $index => $item) {

            $entity = new $nom_entité;
            $entity->$DynamicMethode($item[0]);

            $em->persist($entity);
            $em->flush();

        }

    }

}