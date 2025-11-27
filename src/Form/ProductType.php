<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CategoryMetier;
use App\Entity\CategoryProjet;
use App\Entity\CategoryTraveaux;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('titre')
            ->add('description')
            ->add('stock')
        ->add('image', FileType::class, [
                       'label' => "Image (fichier)",
                       'required' => true,
                       'mapped' => false 
])                   
            ->add('Traveaux', EntityType::class, [
                'class' => CategoryTraveaux::class,
                'choice_label' => 'name',
            ])
        

                    
            ->add('Metier', EntityType::class, [
                'class' => CategoryMetier::class,
                'choice_label' => 'nom',
            ])

                        
            ->add('Projet', EntityType::class, [
                'class' => CategoryProjet::class,
                'choice_label' => 'nom',
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
