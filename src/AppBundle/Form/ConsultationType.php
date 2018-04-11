<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use AppBundle\Form\Type\DateTimePickerType;



class ConsultationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['entity_manager'];
        $medecinId = $options['medecinId'];
        $consultations = $em->getRepository('AppBundle:Consultation')->findByIdMedecin($medecinId);
        //var_dump($consultations);
        $datesToDisable = array();
        foreach ($consultations as $temp) {
          $date = $temp->getDateRDV();
          array_push($datesToDisable,date_format($date,"Y/m/d"));
          //var_dump($date);
        }
        $builder->add('nomPatient',HiddenType::class)
    ->add('nomMedecin',HiddenType::class)
    ->add('idPatient',HiddenType::class)
    ->add('idMedecin',HiddenType::class)
    ->add('dateCreation',DateType::class,array('label' => false, 'format' => 'dd-MM-yyyy', 'disabled' => true , 'attr' => array('style' => 'display:none')))
    ->add('dateRDV',DateTimeType::class,array(
      'widget' => 'single_text',
      'html5' => false,
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
        $resolver->setRequired('entity_manager');
        $resolver->setRequired('medecinId');
    }

    public function getDefaultOptions(array $options)
{
    return array(
        'csrf_protection' => false,
        // Rest of options omitted
    );
}

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_consultation';
    }


}
