<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adress')
            ->add('latitude')
            ->add('longitude')
            ->add('tel_fixe')
            ->add('tel_autre')
            ->add('email')
            ->add('site')
            ->add('speciality')
            ->add('price')
            ->add('description')
            ->add('pictures',FileType::class,[
                'multiple' => true,
                'required' => false
            ])
        ;
    }
}
