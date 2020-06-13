<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class Picture3Fixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<200;$i++)
        {
            $eventRepository =  $manager->getRepository(Event::class);
            $picture = new Picture();
            $picture->setUrl('url_'.$i);
            $picture->setName('name_'.$i);
            $picture->setEvent($eventRepository->find((mt_rand(0, 20))));
            $manager->persist($picture);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 3;
    }
}
