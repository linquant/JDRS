<?php
namespace App\Controller;

use App\Controller\SujetController;
use App\Repository\SujetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Roleplay;
use App\Entity\Sujet;
use App\Controller\RoleplayController;
use App\Form\Roleplaytype;

use Symfony\Component\HttpFoundation\Request;


class GameController extends roleplayController
{

    public function Game(Request $request,$id)
    {

//        Acceder au repo
//        $repo = $this->getDoctrine()->getManager()->getRepository(Sujet::class);
//
//      $sujet= $repo->rand_sujet();

 //       print_r($sujet["sujet"]);

        //Initialise un nouveau jeu ou charge depuis un Id
        //ToDo sécuriser les acces à l'id

        if  ($id == 0){

            $id = null;

            $roleplay = new Roleplay();
            $roleplay->setStory('Nouvelle story');


        }else{

            $roleplay = $this->read_roleplay($id);


        }



        $form = $this->createForm(Roleplaytype::class, new Roleplay());


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $reponse = $form->getData();



            if($reponse->getquestion()){


                $retour = '<p class="question" style="color: orange"> question :'.$reponse->getquestion() .'<br> reponse :' .$this->ouinon($reponse->getdiff()).'</p>';

                $story= $roleplay->getStory(). $retour;



                return $this->redirectToRoute('app_game', array('id' =>  $this->save($story,$id)));

            }

            if($reponse->getaction()){


                $retour = $reponse->getaction();

                $story= $roleplay->getStory().'<br>' .$retour .'<br>'.$this->twist();



                return $this->redirectToRoute('app_game', array('id' =>  $this->save($story,$id)));

            }


        }

        return $this->render('game.html.twig', array('form' => $form->createView(),'story' => $roleplay->getStory()));

    }

    public function page_list_roleplay(){

          $repo = $this->getDoctrine()->getManager()->getRepository(Roleplay::class);

        $list = $repo->findAll();



        return $this->render('listgame.html.twig',array('list' => $list));



    }
    public function home(){


        return $this->render('home.html.twig');
    }

    public function explications(){

        $content = array(
            'seotitle' => 'Explications du jeu de role solo  ',

            'title' => 'Explications ',
            'content' => 'contenu'
        );

        return $this->render('content.html.twig',$content   );
    }


    public function regles(){

        $content = array(
            'seotitle' => 'Les règles du jeu de role sans Maitre des jeux',
            'title' => 'Régles ',
            'content' => 'Les régles du jeu'
        );

        return $this->render('content.html.twig',$content);
    }

    public function des($nbreface){

        return rand(1 , $nbreface);
    }

    /**
     * @param $diff
     * @return string
     * Retourne oui ou non en fonction d'un jet de des et d'une difficulté passée en paramètre
     */
    public function ouinon($diff){

        if ( $this->des(10) >= $diff){
            return 'oui';
        }
        else{
            return "Non";
        }

    }

    public function twist()
    {

//        if ($this->des(10) == $this->des(10)) {
        if (true) {

            return "Un évenement se produit :".$this->list_twit();

        }
    }

    public function list_twit(){

        $list_twist = [ 'piège',
                        ' Vous faites la connaissance d\'une nouvelle personne',
                        ' Changement de lieu',
                        ' Agression',
                        ' Evenement anodin',
                        ' Vous trouvez un objet',
                        ' Num 7',
                        ' Num 8',
                        ' Num 9',
                        ' Num 10',
        ] ;
        return $list_twist[array_rand($list_twist, 1)];
    }

    public function evenement_anodin(){





    }

}



