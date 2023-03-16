<?php

namespace App\DataFixtures;

use App\Entity\Harbor;
use App\Entity\Tide;
use App\Entity\Day;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $harbor = new Harbor();
        $harbor->setName("Le Havre");
        $harbor->setLatitude("49.49437");
        $harbor->setLongitude("0.107929");
        for($i = 0; $i < 7; $i++){
            $tide = new Tide();
            $tide->setCoefficient(2.6);
            $tide->setHighHeight(6.2);
            $tide->setLowHeight(2.2);
            $tide->setHighHour(new \DateTime);
            $tide->setLowHour(new \DateTime);
            $tide->setHarbor($harbor);
            $manager->persist($tide);
        }

        $manager->persist($harbor);

        $manager->flush();
    }
}
