<?php

namespace App\Form;

use App\Entity\CategoryTraveaux;
use Symfony\Component\Finder\Iterator\FileTypeFilterIterator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryTraveaux1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         {
        $builder
            ->add('name')
            ->add('description')
             ->add('image', FileType::class, [
                       'label' => "Image (fichier)",
                       'required' => true,
                       'mapped' => false 
])    ;     
    }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryTraveaux::class,
        ]);
    }
}
