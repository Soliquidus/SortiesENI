<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{

    public const EVENT1_REFERENCE = 'Sortie Concerts Michelet';
    public const EVENT2_REFERENCE = 'Sortie Visite chateau';
    public const EVENT3_REFERENCE = 'Sortie Marché des Lices';
    public const EVENT4_REFERENCE = 'Sortie Bars rue de la Soif';
    public const EVENT5_REFERENCE = 'Sortie Conférence Java';
    public const EVENT6_REFERENCE = 'Sortie Soirée ciné';
    public const EVENT7_REFERENCE = 'Sortie surf CDA';
    public const EVENT8_REFERENCE = 'Sortie golf Rennes';
    public const EVENT9_REFERENCE = 'Sortie aux Sables';
    public const EVENT10_REFERENCE = 'Sortie Réunion CDA';
    public const EVENT11_REFERENCE = 'Sortie Escape Game Niort';
    public const EVENT12_REFERENCE = 'Conférence numérique';

    public function load(ObjectManager $manager)
    {
        $event = new Event();
        $event->setTitle("Concerts metal à la Scène Michelet");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS1_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration("Toute la soirée");
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+18 days +2 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+18 days  + 5 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-5 days')));
        $event->setDescription("Soirée metal progressif à Michelet !");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS1_REFERENCE));
        $event->setSubscriptionsMax(7);
        $event->setUrlPicture('https://www.vacarm.net/vacarm_wp3/wp-content/uploads/2020/01/devanture-scene-michelet-avant-travaux.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER1_REFERENCE));
        $this->addReference(self::EVENT1_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Petite virée au château");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS1_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('Toute l\'après midi');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+5 days - 4 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+5 days  + 1 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-1 day')));
        $event->setDescription("Visite du château des Ducs de Bretagne et flânerie dans les rues de Bouffay ensuite.");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS2_REFERENCE));
        $event->setSubscriptionsMax(10);
        $event->setUrlPicture('https://mom-art.org/wp-content/uploads/2014/10/Ch%C3%A2teau-des-ducs-de-Bretagne.-Nantes-%C2%A9-Philippe-Piron-_-LVAN-1024x819.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER1_REFERENCE));
        $this->addReference(self::EVENT2_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Les joies du Marché des Lices");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS2_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('Fin de matinée - milieu d\'après-midi');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+15 days - 7 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+15 days  - 2 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-8 days')));
        $event->setDescription("Savourer les produits du marché autour d'un verre.");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS3_REFERENCE));
        $event->setSubscriptionsMax(5);
        $event->setUrlPicture('https://i.pinimg.com/originals/75/cb/b8/75cbb8032cf8b3a1d288cd318966d102.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER2_REFERENCE));
        $this->addReference(self::EVENT3_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Soirée dans la Rue de la Soif");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS2_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('Toute la nuit');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+28 days + 3 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+28 days  + 12 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-25 days')));
        $event->setDescription("Arpentons la rue de la Soif pour une soirée mémorable");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS4_REFERENCE));
        $event->setSubscriptionsMax(5);
        $event->setUrlPicture('https://cdn.radiofrance.fr/s3/cruiser-production/2016/04/a2f8323b-6ee1-4f04-8ad7-fe7a26491347/870x489_rue_de_la_soif_rennes.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER2_REFERENCE));
        $this->addReference(self::EVENT4_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Conférence Java");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS4_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration("4 heures");
        $event->setBeginsAt(new \DateTime('now'));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('-1 days - 5 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-13 days - 1 hour')));
        $event->setDescription("Conférence sur le framework Spring de Java.");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS6_REFERENCE));
        $event->setSubscriptionsMax(20);
        $event->setUrlPicture('https://www.cobaltpoitiers.fr/wp-content/uploads/2020/10/le_grand_salon2-1024x683.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER4_REFERENCE));
        $this->addReference(self::EVENT5_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Soirée ciné");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS3_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('Toute la soirée');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+15 days + 2 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+15 days  + 5 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-28 days')));
        $event->setDescription("Soirée ciné avec choix du film sur place.");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS5_REFERENCE));
        $event->setSubscriptionsMax(6);
        $event->setUrlPicture('https://cdt85.media.tourinsoft.eu/upload/concorde-la-roche-sur-yon-85-loi-1.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER3_REFERENCE));
        $this->addReference(self::EVENT6_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Sortie plage/surf pour la promo CDA");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS1_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('Toute la journée');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+15 days - 9 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+15 days  + 3 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-3 days')));
        $event->setDescription("Journée plage / surf pour fêter la fin des cours pour les CDA !");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS8_REFERENCE));
        $event->setSubscriptionsMax(25);
        $event->setUrlPicture('https://www.supinvest.fr/contents/file/3071/plage-de-saint-brevin-des-pins.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER5_REFERENCE));
        $this->addReference(self::EVENT7_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Après-midi golf pour la promo DWWM");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS2_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('En après-midi');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+20 days - 4 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+20 days  + 1 hour')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-5 days')));
        $event->setDescription("Après-midi détente golf avant la fin des cours pour la promo DWWM.");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS9_REFERENCE));
        $event->setSubscriptionsMax(15);
        $event->setUrlPicture('https://bluegreen.fr/wp-content/uploads/2019/10/bluegreen_golf_rennes-e1571740780632.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER7_REFERENCE));
        $this->addReference(self::EVENT8_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Sortie plage au Sables");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS3_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('Toute la journée');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+29 days - 10 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+20 days  + 1 hour')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-10 days')));
        $event->setDescription("Journée baignade et bronzette aux Sables !");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS11_REFERENCE));
        $event->setSubscriptionsMax(10);
        $event->setUrlPicture('https://www.lessablesdolonne-tourisme.com/var/ayaline/storage/images/les-sables-d-olonne/sejourner/comment-venir/8199-34-fre-FR/Comment-venir.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER7_REFERENCE));
        $this->addReference(self::EVENT9_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Réunion de bienvenue pour la future promo CDA");
        $event->setCampus($this->getReference(CampusFixtures::ADMIN_CAMPUS_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('Toute la matinée');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+12 days - 10 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+12 days  -6 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-4 days')));
        $event->setDescription("L'ENI vous propose une réunion afin d'acceuillir ses futurs étudiants CDA.");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS7_REFERENCE));
        $event->setSubscriptionsMax(45);
        $event->setUrlPicture('https://f.hellowork.com/blogdumoderateur/2021/03/ENI-Nantes-1200x850.jpg');
        $event->setCreator($this->getReference(UserFixtures::ADMIN_REFERENCE));
        $this->addReference(self::EVENT10_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("Escape Game");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS4_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('En après-midi');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+12 days - 4 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+12 days  -2 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-13 days')));
        $event->setDescription("Petite partie d'Escape Game pour faire fonctionner nos méninges en dehors de lignes de codes !");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS10_REFERENCE));
        $event->setSubscriptionsMax(8);
        $event->setUrlPicture('https://media-cdn.tripadvisor.com/media/photo-s/0d/9c/40/f0/entree-escape-yourself.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER10_REFERENCE));
        $this->addReference(self::EVENT11_REFERENCE, $event);
        $manager->persist($event);

        $event = new Event();
        $event->setTitle("L'écologie dans le numérique");
        $event->setCampus($this->getReference(CampusFixtures::USER_CAMPUS1_REFERENCE));
        $event->setState('Ouvert');
        $event->setDuration('L\'après-midi');
        $event->setBeginsAt(date_add(new \DateTime('now'), date_interval_create_from_date_string('+12 days - 4 hours')));
        $event->setEndsAt(date_add(new \DateTime('now'),date_interval_create_from_date_string('+12 days  -2 hours')));
        $event->setCreationDate(date_add(new \DateTime('now'),date_interval_create_from_date_string('-3 days')));
        $event->setDescription("Débat autour de l'écologie dans le numérique et ses résponsabilités.");
        $event->setAddress($this->getReference(AddressFixtures::ADDRESS12_REFERENCE));
        $event->setSubscriptionsMax(25);
        $event->setUrlPicture('https://www.bedouk.fr/mediatheque/annonceur/4/6/6/0000642664_920x572.jpg');
        $event->setCreator($this->getReference(UserFixtures::USER6_REFERENCE));
        $this->addReference(self::EVENT12_REFERENCE, $event);
        $manager->persist($event);

        $manager->flush();


    }

    public function getDependencies(): array
    {
        return array(
            CampusFixtures::class,
            AddressFixtures::class,
            UserFixtures::class
        );
    }
}
