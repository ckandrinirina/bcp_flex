<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class PictureFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<200;$i++)
        {
            $picture = new Picture();
            $picture->setUrl('url_'.$i);
            $picture->setName('name_'.$i);
            $manager->persist($picture);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 1;
    }
}