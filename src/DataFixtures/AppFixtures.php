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
        $day1 = new Day();
        $day2 = new Day();
        $tide1 = new Tide();
        $tide2 = new Tide();
        $tide3 = new Tide();
        $tide4 = new Tide();

        $manager->persist($harbor);
        $manager->persist($day1);
        $manager->persist($day2);
        $manager->persist($tide1);
        $manager->persist($tide2);
        $manager->persist($tide3);
        $manager->persist($tide4);

        $manager->flush();
    }
}
