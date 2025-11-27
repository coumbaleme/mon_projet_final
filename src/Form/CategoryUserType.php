<?php

namespace App\Form;


use App\Entity\CategoryUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         
         {
        $builder
            ->add('name')
            ->add('description')
            ->add('Email')
            ->add('password');
    }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryUser::class,
        ]);
    }
}
