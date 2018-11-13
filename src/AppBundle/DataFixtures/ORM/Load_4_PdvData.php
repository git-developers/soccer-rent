<?php

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PointOfSale;

class Load_4_PdvData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $entity = new PointOfSale();
        $entity->setCode('111');
        $entity->setName('cancha 1');
        $entity->setTelephone('123456');
        $entity->setLatitude('-12.0752286');
        $entity->setLongitude('-76.9113272');
        $entity->setDescription('Ave. La Fontana #234, La Molina');
        $entity->setImage('https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png');
        $manager->persist($entity);

        $entity = new PointOfSale();
        $entity->setCode('222');
        $entity->setName('cancha 2');
        $entity->setTelephone('98765454');
        $entity->setLatitude('-12.0839825');
        $entity->setLongitude('-76.9705258');
        $entity->setDescription('Ave. Los ingenieros #456, Lince');
        $entity->setImage('https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png');
        $manager->persist($entity);

        $entity = new PointOfSale();
        $entity->setCode('333');
        $entity->setName('cancha 3');
        $entity->setTelephone('76532345');
        $entity->setLatitude('-12.0548184');
        $entity->setLongitude('-76.964568');
        $entity->setDescription('Ave. Flora Tristan #789, Santa Patricia, La Molina');
        $entity->setImage('https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png');
        $manager->persist($entity);


        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 4;
    }
}