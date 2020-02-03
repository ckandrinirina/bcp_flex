<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EtablissementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, ['attr' => ['class' => 'form-control']])
                ->add('adresse', TextType::class, ['attr' => ['class' => 'form-control']])
                ->add('fixe', TelType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('autre', TelType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('email', EmailType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('site', UrlType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('specialite', TextType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('note', TextType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('type', TextType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('description', TextareaType::class, ['attr' => ['class' => 'form-control'], 'required' => false])
                ->add('prix', NumberType::class, ['attr' => ['class' => 'form-control'], 'required' => false]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Etablissement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_etablissement';
    }


}
