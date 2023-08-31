<?php

namespace App\Form;


use App\Entity\Categorie;
use App\Entity\Nft;
use App\Entity\Image;



use App\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NFTCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valeur_euro', TextType::class, [
                'label' => 'Valeur en Euros'
            ])
            ->add('prix_eth', TextType::class, [
                'label'=>'Prix en ETH',
            ])
            ->add('is_en_vente', CheckboxType::class, [
                'label' => 'En vente',
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Catégorie(s)',
                'class' => Categorie::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'nomCategorie',
                'required' => false,
            ])
            
            ->add( 'image', ImageType::class, [
                'label' => false,
                'data_class' => Image::class,
                'required' => true,
                
            ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nft::class,
        ]);
    }
}
