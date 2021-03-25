<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $_encoder;
    public const ADMIN_REFERENCE = 'admin';
    public const USER1_REFERENCE = 'Tibo';
    public const USER2_REFERENCE = 'Jimmy';
    public const USER3_REFERENCE = 'Robert';
    public const USER4_REFERENCE = 'Malkoswitch';
    public const USER5_REFERENCE = 'Juliette';
    public const USER6_REFERENCE = 'John';
    public const USER7_REFERENCE = 'Léa';
    public const USER8_REFERENCE = 'Anthony';
    public const USER9_REFERENCE = 'Mireille';
    public const USER10_REFERENCE = 'Quentin';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->_encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setUsername('admin');
        $user->setFirstName('Admin');
        $user->setLastName('Admin');
        $user->setEmail('admin@sorties-eni.com');
        $user->setPhoneNumber(123456789);
        $user->setPassword($this->_encoder->encodePassword($user, 'admin'));
        $user->setCampus($this->getReference(CampusFixtures::ADMIN_CAMPUS_REFERENCE));
        $this->addReference(self::ADMIN_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Tib85');
        $user->setFirstName('Tibo');
        $user->setLastName('Pfeifer');
        $user->setEmail('tibo.pfeifer2020@campus-eni.com');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS1_REFERENCE));
        $this->addReference(self::USER1_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Ju01');
        $user->setFirstName('Juliette');
        $user->setLastName('Binocle');
        $user->setEmail('juliette.binocle2012@campus-eni.com');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS1_REFERENCE));
        $this->addReference(self::USER5_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Roro88');
        $user->setFirstName('John');
        $user->setLastName('Roméo');
        $user->setEmail('john.romeo2016@campus-eni.com');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS1_REFERENCE));
        $this->addReference(self::USER6_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Jim02');
        $user->setFirstName('Jimmy');
        $user->setLastName('Androx');
        $user->setEmail('jimmy.androx1995@campus-eni.fr');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS2_REFERENCE));
        $this->addReference(self::USER2_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Lili87');
        $user->setFirstName('Léa');
        $user->setLastName('Seypadoux');
        $user->setEmail('lea.seypadoux2009@campus-eni.fr');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS2_REFERENCE));
        $this->addReference(self::USER7_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Antoto');
        $user->setFirstName('Anthony');
        $user->setLastName('Chopskins');
        $user->setEmail('antony.chopskins1988@campus-eni.fr');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS2_REFERENCE));
        $this->addReference(self::USER8_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Robby31');
        $user->setFirstName('Robert');
        $user->setLastName('Dupont');
        $user->setEmail('robert.dupont2019@campus-eni.fr');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS3_REFERENCE));
        $this->addReference(self::USER3_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Mimi85');
        $user->setFirstName('Mireille');
        $user->setLastName('Matemieux');
        $user->setEmail('mireille.matemieux2002@campus-eni.fr');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS3_REFERENCE));
        $this->addReference(self::USER9_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('Quille75');
        $user->setFirstName('Quentin');
        $user->setLastName('Ducreux');
        $user->setEmail('quentin.ducreux2006@campus-eni.fr');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS3_REFERENCE));
        $this->addReference(self::USER10_REFERENCE, $user);
        $manager->persist($user);

        $user = new User();
        $user->setActive(true);
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('JonnyBoy');
        $user->setFirstName('John');
        $user->setLastName('Malkoswitch');
        $user->setEmail('john.malkoswitch2009@campus-eni.fr');
        $user->setPassword($this->_encoder->encodePassword($user, 'user'));
        $user->setPhoneNumber(123456789);
        $user->setCampus($this->getReference(CampusFixtures::USER_CAMPUS4_REFERENCE));
        $this->addReference(self::USER4_REFERENCE, $user);
        $manager->persist($user);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return array(
            CampusFixtures::class,
        );
    }
}
