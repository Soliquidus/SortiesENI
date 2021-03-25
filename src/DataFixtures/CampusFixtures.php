<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{

    public const ADMIN_CAMPUS_REFERENCE = 'Campus Admin';
    public const USER_CAMPUS1_REFERENCE = 'Campus Saint-Herblain';
    public const USER_CAMPUS2_REFERENCE = 'Campus Chartres-de-Bretagne';
    public const USER_CAMPUS3_REFERENCE = 'Campus La Roche-Sur-Yon';
    public const USER_CAMPUS4_REFERENCE = 'Campus Poitiers';

    public function load(ObjectManager $manager)
    {
        $campus = new Campus();
        $campus->setCampusName('ENI');
        $manager->persist($campus);
        $manager->flush();

        $this->addReference(self::ADMIN_CAMPUS_REFERENCE, $campus);

        $campus = new Campus();
        $campus->setCampusName('Saint-Herblain');
        $manager->persist($campus);
        $manager->flush();

        $this->addReference(self::USER_CAMPUS1_REFERENCE, $campus);

        $campus = new Campus();
        $campus->setCampusName('Chartres-de-Bretagne');
        $manager->persist($campus);
        $manager->flush();

        $this->addReference(self::USER_CAMPUS2_REFERENCE, $campus);

        $campus = new Campus();
        $campus->setCampusName('La Roche-Sur-Yon');
        $manager->persist($campus);
        $manager->flush();

        $this->addReference(self::USER_CAMPUS3_REFERENCE, $campus);

        $campus = new Campus();
        $campus->setCampusName('Poitiers');
        $manager->persist($campus);
        $manager->flush();

        $this->addReference(self::USER_CAMPUS4_REFERENCE, $campus);

    }
}
