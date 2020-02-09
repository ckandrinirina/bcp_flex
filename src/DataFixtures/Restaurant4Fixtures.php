<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class Restaurant4Fixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<20;$i++)
        {
            $restaurant = new Restaurant();
            $restaurant->setNom('nom_'.$i);
            $restaurant->setAdress('adresses_'.$i);
            $restaurant->setDescription('descriptions_'.$i);
            $restaurant->setEmail('email_'.$i);
            $restaurant->setPrice(random_int(400,5000));
            $restaurant->setSite('a_'.$i.'.com');
            $restaurant->setSpeciality('speciality_'.$i);
            $restaurant->setTelAutre('tel autre'.$i);
            $restaurant->setTelFixe('tel fixe'.$i);
            $restaurant->setViewers(random_int(1,100));
            $manager->persist($restaurant);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 4;
    }
}
