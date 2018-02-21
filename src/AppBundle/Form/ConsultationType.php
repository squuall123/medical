<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ConsultationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomPatient')->add('nomMedecin')->add('idPatient',HiddenType::class, array(
    'data' => 'abcdef',
))->add('idMedecin',HiddenType::class, array(
    'data' => 'abcdef',
))->add('dateCreation',HiddenType::class, array(
    'data' => 'abcdef',
))->add('dateRDV',DateType::class, array(
    'placeholder' => array(
        'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
    )))->add('description');
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
