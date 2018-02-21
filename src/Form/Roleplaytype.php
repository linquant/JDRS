<?php
namespace App\Form;

//use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class Roleplaytype  extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('question',TextType::class, array('required' => false))
            ->add('diff',IntegerType::class, array('data' => 5,'required' => false))
            ->add('action', TextareaType::class, array('required' => false))

            ->add('Valider', SubmitType::class)
                  ;



    }
}