<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Picture;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class EventFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pictureRepository = $manager->getRepository(Picture::class);
        for($i=0;$i<20;$i++)
        {
            $event = new Event();
            $event->setNom('nom_'.$i);
            $event->setPresentation('presentation_'.$i);
            $event->setDate(new DateTime());
            $event->setPlace('place_'.$i);
            $manager->persist($event);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}
