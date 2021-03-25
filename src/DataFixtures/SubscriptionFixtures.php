<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $subscription1 = new Subscription();
        $subscription1->setEvent($this->getReference(EventFixtures::EVENT1_REFERENCE));
        $subscription1->setSubscriber($this->getReference(UserFixtures::USER2_REFERENCE));
        $subscription1->setSubscriptionDate(new \DateTime("now"));
        $manager->persist($subscription1);

        $subscription2 = new Subscription();
        $subscription2->setEvent($this->getReference(EventFixtures::EVENT2_REFERENCE));
        $subscription2->setSubscriber($this->getReference(UserFixtures::USER1_REFERENCE));
        $subscription2->setSubscriptionDate(new \DateTime("now"));
        $manager->persist($subscription2);

        $subscription3 = new Subscription();
        $subscription3->setEvent($this->getReference(EventFixtures::EVENT3_REFERENCE));
        $subscription3->setSubscriber($this->getReference(UserFixtures::USER7_REFERENCE));
        $subscription3->setSubscriptionDate(new \DateTime("now"));
        $manager->persist($subscription3);

        $subscription4 = new Subscription();
        $subscription4->setEvent($this->getReference(EventFixtures::EVENT4_REFERENCE));
        $subscription4->setSubscriber($this->getReference(UserFixtures::USER2_REFERENCE));
        $subscription4->setSubscriptionDate(new \DateTime("now"));
        $manager->persist($subscription4);

        $manager->flush();

        $event1 = $this->getReference(EventFixtures::EVENT1_REFERENCE);
        $user1 = $this->getReference(UserFixtures::USER2_REFERENCE);
        $event2 = $this->getReference(EventFixtures::EVENT3_REFERENCE);
        $user2 = $this->getReference(UserFixtures::USER1_REFERENCE);
        $event3 = $this->getReference(EventFixtures::EVENT5_REFERENCE);
        $user3 = $this->getReference(UserFixtures::USER1_REFERENCE);
        $event4 = $this->getReference(EventFixtures::EVENT4_REFERENCE);
        $user4 = $this->getReference(UserFixtures::USER2_REFERENCE);

        $event1->addSubscription($subscription1);
        $user1->addSubscription($subscription1);
        $event2->addSubscription($subscription2);
        $user2->addSubscription($subscription2);
        $event3->addSubscription($subscription3);
        $user3->addSubscription($subscription3);
    }

    public function getDependencies(): array
    {
        return array(
            EventFixtures::class,
            UserFixtures::class
        );
    }
}
