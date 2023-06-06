<?php

namespace App\DataFixtures;

use App\Entity\Voiture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class VoitureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i = 1; $i <= 15; $i++)
        {
            $prix = rand(1000, 100000) ;
            $voiture = new Voiture;
            $voiture->setMarque("marque n°$i")
                    ->setModele("modèle n°$i")
                    ->setPrix($prix)
                    ->setDescription("description de ma voiture ta vue tu connais n°$i");
                    
            $manager->persist($voiture);
        }
        $manager->flush();
    }
}
