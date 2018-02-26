<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SujetType  extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('sujet',TextType::class, array('required' => false))

            ->add('Valider', SubmitType::class)
                  ;

   }
}