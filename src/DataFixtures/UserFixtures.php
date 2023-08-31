<?php

namespace App\DataFixtures;

use App\Entity\User;

use App\Repository\AdresseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    protected UserPasswordHasherInterface $hasher;
    protected AdresseRepository $adresseRepository;

    public function __construct(UserPasswordHasherInterface $hasher, AdresseRepository $adresseRepository)
    {
        $this->hasher = $hasher;
        $this->adresseRepository = $adresseRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $users = [
            [
                
                'email' => 'admin@gmail.com',
                'roles' => 'ROLE_ADMIN',
                'password' => 'azerty',
                'nom' => 'tata',
                'prenom' => 'Josy',
                'date_naissance' => '1983-11-26',
                'is_proprietaire' => '1',
            ],
            [
                
                'email' =>'momo@hotmail.com',
                'roles' => 'ROLE_USER',
                'password' => '123456',
                'nom' => 'titi',
                'prenom' => 'momo',
                'date_naissance' => '07/03/1983',
                'is_proprietaire' => '0',
            ],
        ];

        $adresses = $this->adresseRepository->findAll();

        foreach ($users as $utilisateur) {
            $user = new User();
            
            
            $user->setEmail($utilisateur['email']);
            $password = $this->hasher->hashPassword($user, $utilisateur['password']);
            $user->setPassword($password);
            $user->setRoles([$utilisateur['roles']]);
            $user->setNom($utilisateur['nom']);
            $user->setPrenom($utilisateur['prenom']);
            $user->setDateNaissance(new \DateTime($utilisateur['date_naissance']));
            $user->setIsProprietaire($utilisateur['is_proprietaire']);

            
                $index = mt_rand(0, count($adresses) -1);
                $user->setAdresses($adresses[$index]);
                unset($adresses[$index]);
            

            $manager->persist($user);

            

        }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AdresseFixtures::class,
        ];
    }
}