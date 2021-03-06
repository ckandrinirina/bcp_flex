<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('presentation')
            ->add('date',DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
            ])
            ->add('place')
            ->add('pictures',FileType::class,[
                'multiple' => true,
                'required' => false
            ])
        ;
    }
}
