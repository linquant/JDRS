<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RoleplayType  extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

//            ->add('question',TextType::class, array('required' => false))
            ->add('diff',ChoiceType::class,
                array('required' => false,
                    'choices'  => array(
                                        '1' => 1,
                                        '2' => 2,
                                        '3' => 3,
                                        '4' => 4,
                                        '5' => 5,
                                        '6' => 6,
                                        '7' => 7,
                                        '8' => 8,
                                        '9' => 9,
                                        '10' => 10,


                        ),
                ))

            ->add('action', TextareaType::class, array( 'label'    => 'Show this entry publicly?','required' => false))

            ->add('Valider', SubmitType::class)
                  ;



    }
}