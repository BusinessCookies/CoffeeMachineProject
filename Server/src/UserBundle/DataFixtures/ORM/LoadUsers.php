<?php
// src/UserBundle/DataFixtures/ORM/LoadUsers.php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class LoadUsers implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Add admin
    $user = new User;
    $user->setUsername("admin");
    $user->setPassword("admin");
    $user->setSalt('');
    $user->setRoles(array('ROLE_ADMIN'));
    $manager->persist($user);
    
    // Add raspi
    $user = new User;
    $user->setUsername("raspi");
    $user->setPassword("raspi");
    $user->setSalt('');
    $user->setRoles(array('ROLE_RASPI'));
    $manager->persist($user);
    
    // On déclenche l'enregistrement
    $manager->flush();
  }

}
