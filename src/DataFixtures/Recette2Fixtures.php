<?php

namespace App\DataFixtures;

use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class Recette2Fixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<20;$i++)
        {
            $recette = new Recette();
            $recette->setNom('nom_'.$i);
            $recette->setEtapes('etapes_'.$i);
            $manager->persist($recette);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}
