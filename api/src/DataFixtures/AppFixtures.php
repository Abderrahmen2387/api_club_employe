<?php

namespace App\DataFixtures;

use App\Entity\Invitation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail("user1@live.fr")
            ->setName('user1')
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$SfyoJCyuXwaZljuG6zGx9w$bU/IvG4VkMvOatrEspFFKJBdjzbdAwe0xQra3W2WTgI')
            ->setRoles([]);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail("user2@live.fr")
            ->setName('user2')
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$SfyoJCyuXwaZljuG6zGx9w$bU/IvG4VkMvOatrEspFFKJBdjzbdAwe0xQra3W2WTgI')
            ->setRoles([]);
        $manager->persist($user2);


        $user3 = new User();
        $user3->setEmail("user3@live.fr")
            ->setName('user3')
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$SfyoJCyuXwaZljuG6zGx9w$bU/IvG4VkMvOatrEspFFKJBdjzbdAwe0xQra3W2WTgI')
            ->setRoles([]);
        $manager->persist($user3);


        // user 1
        $invitation1 = new Invitation();
        $invitation1->setComment("User1 => User2")
            ->setSender($user1)
            ->setGuest($user2);
        $manager->persist($invitation1);

        $invitation = new Invitation();
        $invitation->setComment("User1 => User3")
            ->setSender($user1)
            ->setGuest($user3);
        $manager->persist($invitation);


        //user 2
        $invitation = new Invitation();
        $invitation->setComment("User2 => User1")
            ->setSender($user2)
            ->setGuest($user1);
        $manager->persist($invitation);

        $invitation = new Invitation();
        $invitation->setComment("User2 => User3")
            ->setSender($user2)
            ->setGuest($user3);
        $manager->persist($invitation);

        //user 3
        $invitation = new Invitation();
        $invitation->setComment("User3 => User2")
            ->setSender($user3)
            ->setGuest($user2);
        $manager->persist($invitation);

        $manager->flush();
    }
}
