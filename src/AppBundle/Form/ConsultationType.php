<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConsultationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomPatient',HiddenType::class)
    ->add('nomMedecin',HiddenType::class)
    ->add('idPatient',HiddenType::class)
    ->add('idMedecin',HiddenType::class)
    ->add('dateCreation',DateType::class,array('label' => false, 'format' => 'dd-MM-yyyy', 'disabled' => true , 'attr' => array('style' => 'display:none')))
    ->add('dateRDV',DateType::class,array(

    
    'widget'=> 'single_text',
      'days' => range(1,31),
      'attr' => ['class' => 'js-datepicker'],
    ))
    ->add('description',TextareaType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Consultation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_consultation';
    }


}
