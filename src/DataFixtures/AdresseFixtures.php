<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdresseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $adresses = [
            [
                'ligne1'=> '8b',
                'ligne2'=>'Rue', 
                'ligne3'=>'de la République',
                'code_postal' =>'75012',
                'ville' => 'Paris',
                'departement' => 'ile de france'
            ],
            [
                'ligne1'=> '34',
                'ligne2'=>'Boulevard' ,
                'ligne3'=>'Saint-Germain',
                'code_postal' =>'92600',
                'ville' => 'Nanterre',
                'departement' => 'Hauts de seine'
            
            ],
        ];

        foreach ($adresses as $adresse) {
            $a = new Adresse();
            $a -> setLigne1($adresse['ligne1']);
            $a ->setLigne2($adresse['ligne2']);
            $a -> setLigne3($adresse['ligne3']);
            $a -> setCodePostal($adresse['code_postal']);
            $a -> setVille($adresse['ville']);
            $a -> setDepartement($adresse['departement']);

            
            $manager->persist($a);
        }
        

        $manager->flush();
    }
}
