<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{

    public const CITY1_REFERENCE = 'Ville Nantes';
    public const CITY2_REFERENCE = 'Ville Rennes';
    public const CITY3_REFERENCE = 'Ville La Roche-Sur-Yon';
    public const CITY4_REFERENCE = 'Ville Niort';
    public const CITY5_REFERENCE = 'Ville Saint-Herblain';
    public const CITY6_REFERENCE = 'Ville Poitiers';
    public const CITY7_REFERENCE = 'Ville Saint-Brevin';
    public const CITY8_REFERENCE = 'Ville Saint-Jacques';
    public const CITY9_REFERENCE = 'Ville Les Sables';

    public function load(ObjectManager $manager)
    {
        $city = new City();
        $city->setCityName('Nantes');
        $city->setPostalCode('44100');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY1_REFERENCE, $city);

        $city = new City();
        $city->setCityName('Rennes');
        $city->setPostalCode('35000');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY2_REFERENCE, $city);

        $city = new City();
        $city->setCityName('La Roche-Sur-Yon');
        $city->setPostalCode('85000');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY3_REFERENCE, $city);

        $city = new City();
        $city->setCityName('Niort');
        $city->setPostalCode('79000');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY4_REFERENCE, $city);

        $city = new City();
        $city->setCityName('Saint-Herblain');
        $city->setPostalCode('44800');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY5_REFERENCE, $city);

        $city = new City();
        $city->setCityName('Poitiers');
        $city->setPostalCode('86000');
        $manager->persist($city);
        $manager->flush();
        $this->addReference(self::CITY6_REFERENCE, $city);

        $city = new City();
        $city->setCityName('Saint-Brevin-Les-Pins');
        $city->setPostalCode('44250');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY7_REFERENCE, $city);

        $city = new City();
        $city->setCityName('Saint Jacques-de-la-Lande');
        $city->setPostalCode('35136');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY8_REFERENCE, $city);

        $city = new City();
        $city->setCityName('Olonne-sur-Mer');
        $city->setPostalCode('85340');
        $manager->persist($city);
        $manager->flush();

        $this->addReference(self::CITY9_REFERENCE, $city);
    }
}
