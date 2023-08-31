<?php

namespace App\Controller\Admin;

use App\Entity\Nft;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NftCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Nft::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('valeur_euro'),
            IntegerField::new('prix_eth'),
            BooleanField::new('is_en_vente'),
            // ImageField::new('image'),
            AssociationField::new('categories', 'Catégorie(s)')
                ->setFormTypeOptions(['by_reference' => false]),
        ];
    }
    
}
