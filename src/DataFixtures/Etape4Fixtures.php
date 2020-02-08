<?php

namespace App\DataFixtures;

use App\Entity\Etape;
use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class Etape4Fixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<100;$i++)
        {
            $recetteRepository =  $manager->getRepository(Recette::class);
            $etape = new Etape();
            $etape->setDescription('description_'.$i);
            $etape->setRecette($recetteRepository->find((mt_rand(0, 20))));
            $manager->persist($etape);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 4;
    }
}
