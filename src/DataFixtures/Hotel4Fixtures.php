<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class Hotel4Fixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<20;$i++)
        {
            $hotel = new Hotel();
            $hotel->setNom('nom_'.$i);
            $hotel->setAdress('adresses_'.$i);
            $hotel->setDescription('descriptions_'.$i);
            $hotel->setEmail('email_'.$i);
            $hotel->setPrice(random_int(400,5000));
            $hotel->setSite('a_'.$i.'.com');
            $hotel->setSpeciality('speciality_'.$i);
            $hotel->setTelAutre('tel autre'.$i);
            $hotel->setTelFixe('tel fixe'.$i);
            $hotel->setViewers(random_int(1,100));
            $manager->persist($hotel);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 5;
    }
}
