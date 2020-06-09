<?php


namespace CalendrierMedecinsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class RecherchePatientForm extends AbstractType {

public function buildForm(FormBuilderInterface $builder,array $options){

    $builder
        ->add('nom',TextType::class,
        [
            'label'=>'Patient LastName:  ',
            'attr'=>['placeholder'=>'TEXT']
        ])
        
        ->add('prenom',TextType::class,
        [
            'label'=>'Patient FirstName:  ',
            'attr'=>['placeholder'=>'TEXT']
            
        ]);
    }

        
    
}


