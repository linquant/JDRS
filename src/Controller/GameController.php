<?php
namespace App\Controller;

use App\Controller\SujetController;
use App\Entity\Action;
use App\Repository\SujetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Roleplay;
use App\Entity\Sujet;
use App\Controller\RoleplayController;
use App\Form\RoleplayType;

use Symfony\Component\HttpFoundation\Request;


class GameController extends roleplayController
{

    public function Game(Request $request,$id)
    {


        //Initialise un nouveau jeu ou charge depuis un Id
        //ToDo sécuriser les acces à l'id


        if  ($id == 0){

            $id = null;

            $roleplay = new Roleplay();
            $roleplay->setStory('Nouvelle story <br> '.$this->random_scenario());


        }else{

            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $user_id = $this->getUser()->getId();

            $roleplay = $this->read_roleplay($id,$user_id);


        }


        //Génération du formulaire de jeu

        $form = $this->createForm(RoleplayType::class, new Roleplay());


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $reponse = $form->getData();
            $story ="";

            if($reponse->getaction()){


                $story= $roleplay->getStory().' ' .$reponse->getaction() .' '.$this->twist();
                $roleplay->setStory($story);
            }
            if($reponse->getdiff()){


                $retour = $this->ouinon($reponse->getdiff());


                $story= $roleplay->getStory(). $retour;


            }
            return $this->redirectToRoute('app_game', array('id' =>  $this->save($story,$id)));

        }

        return $this->render('game.html.twig', array('form' => $form->createView(),'story' => $roleplay->getStory()));

    }

    public function page_list_roleplay(){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user_id = $this->getUser()->getId();

          $repo = $this->getDoctrine()->getManager()->getRepository(Roleplay::class);

//        $list = $repo->findAll();
        $list = $repo->list_roleplay_by_userId($user_id);




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
            return '<p style="color:green">Réponse : oui</p> ';
        }
        else{
            return "<p style=\"color:red\">Réponse : Non </p>";
        }

    }

    public function twist()
    {

        if ($this->des(100) < 10) {
//        if (true) {

            return "Un évenement se produit :".$this->list_twit();

        }
    }

    public function list_twit(){

        $list_twist = [ 'Vous tomber sur un piège',
                        ' Vous faites la connaissance d\'une nouvelle personne',
                        ' Un événement vous fait changer de lieu',
                        ' Un personnage vous aggresse',
                        ' Vous trouvez un objet',

        ] ;
        return $list_twist[array_rand($list_twist, 1)];
    }

    public function random_scenario(){

        $scenario = "" ;

//        Acceder au repo
        $repo = $this->getDoctrine()->getManager()->getRepository(Sujet::class);
        $sujet= $repo->rand_sujet();

        $repo = $this->getDoctrine()->getManager()->getRepository(Action::class);
        $action= $repo->rand_action();


        $scenario ="Générateur d'idée de scénario : ". ucfirst((string)$sujet["sujet"])." - ".ucfirst((string)$action["action"]);


        return $scenario;
    }

}



