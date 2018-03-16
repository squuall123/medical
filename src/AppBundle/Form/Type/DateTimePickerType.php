<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DateTimePickerType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
                    'widget' => 'single_text', // Important de mettre single_text
                    'model_timezone' => 'Europe/Paris',
                    'html5' => true,
                ))
        ;
    }

    /**
     * Notre nouveau FormType est un dérivé de la classe DateTimeType,
     * on va pouvoir utiliser sa configuration de base
     */
    public function getParent() {
        return DateTimeType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     * C'est le nom du block qui sera repris dans la vue twig du FormType
     */
    public function getBlockPrefix() {
        return 'datetimepicker';
    }

}
