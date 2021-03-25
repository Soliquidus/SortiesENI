<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{

    public const ADDRESS1_REFERENCE = "Adresse Scène Michelet";
    public const ADDRESS2_REFERENCE = "Adresse Château des Ducs";
    public const ADDRESS3_REFERENCE = "Adresse Marché des Lices";
    public const ADDRESS4_REFERENCE = "Adresse Rue de la Soif";
    public const ADDRESS5_REFERENCE = "Adresse Cinéma Le Concorde";
    public const ADDRESS6_REFERENCE = "Adresse Cobalt";
    public const ADDRESS7_REFERENCE = "Adresse ENI";
    public const ADDRESS8_REFERENCE = "Adresse Serpent Océan";
    public const ADDRESS9_REFERENCE = "Adresse Golf Bluegreen";
    public const ADDRESS10_REFERENCE = "Adresse Escape Game Niort";
    public const ADDRESS11_REFERENCE = "Adresse Les Sables";
    public const ADDRESS12_REFERENCE = "Adresse La Cité des Congrès";

    public function load(ObjectManager $manager)
    {
        $address = new Address();
        $address->setTitle('La Scène Michelet');
        $address->setStreet('1 Boulevard Henry Orrion');
        $address->setCity($this->getReference(CityFixtures::CITY1_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS1_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Château des Ducs de Bretagne');
        $address->setStreet('4 Place Marc Elder');
        $address->setCity($this->getReference(CityFixtures::CITY1_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS2_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Le Marché des Lices');
        $address->setStreet('3 Place du Bas des Lices');
        $address->setCity($this->getReference(CityFixtures::CITY2_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS3_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Rue de la Soif');
        $address->setStreet('Rue Saint-Michel');
        $address->setCity($this->getReference(CityFixtures::CITY2_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS4_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Cinéma Le Concorde');
        $address->setStreet('8 rue Gouvion');
        $address->setCity($this->getReference(CityFixtures::CITY3_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS5_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Cobalt');
        $address->setStreet('5 rue Victor Hugo');
        $address->setCity($this->getReference(CityFixtures::CITY6_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS6_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('ENI');
        $address->setStreet(' 3 Rue Michael Faraday');
        $address->setCity($this->getReference(CityFixtures::CITY5_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS7_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Serpent d\'Océan');
        $address->setStreet('Plage, Allée de la Prée de Mindin');
        $address->setCity($this->getReference(CityFixtures::CITY7_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS8_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Golf Bluegreen');
        $address->setStreet('Le Temple du Cerisier');
        $address->setCity($this->getReference(CityFixtures::CITY8_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS9_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Les Sables d\'Olonne');
        $address->setStreet('Rue d\'Assas');
        $address->setCity($this->getReference(CityFixtures::CITY9_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS11_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('Escape Game - Escape Yourself');
        $address->setStreet('17 rue Saint-Symphorien');
        $address->setCity($this->getReference(CityFixtures::CITY4_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS10_REFERENCE, $address);

        $address = new Address();
        $address->setTitle('La Cité des Congrès');
        $address->setStreet('5 Rue de Valmy');
        $address->setCity($this->getReference(CityFixtures::CITY1_REFERENCE));
        $manager->persist($address);
        $this->addReference(self::ADDRESS12_REFERENCE, $address);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            CityFixtures::class,
        );
    }
}
