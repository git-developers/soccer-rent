<?php

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Profile;

class Load_2_ProfileData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $roleCreateUser = $this->getReference('role-create-user');
        $roleEditUser = $this->getReference('role-edit-user');
        $roleDeleteUser = $this->getReference('role-delete-user');
        $roleViewUser = $this->getReference('role-view-user');
        $roleChangepasswordUser = $this->getReference('role-changepassword-user');

        $roleCreatePointofsale = $this->getReference('role-create-pointofsale');
        $roleEditPointofsale = $this->getReference('role-edit-pointofsale');
        $roleDeletePointofsale = $this->getReference('role-delete-pointofsale');
        $roleViewPointofsale = $this->getReference('role-view-pointofsale');

        $roleCreateAclrole = $this->getReference('role-create-aclrole');
        $roleEditAclrole = $this->getReference('role-edit-aclrole');
        $roleDeleteAclrole = $this->getReference('role-delete-aclrole');
        $roleViewAclrole = $this->getReference('role-view-aclrole');

        $roleCreateAclprofile = $this->getReference('role-create-aclprofile');
        $roleEditAclprofile = $this->getReference('role-edit-aclprofile');
        $roleDeleteAclprofile = $this->getReference('role-delete-aclprofile');
        $roleViewAclprofile = $this->getReference('role-view-aclprofile');



        $roleBackend = $this->getReference('role-backend');


        $entity = new Profile();
        $entity->setName('administrador');

        $entity->addRole($roleBackend);

        $entity->addRole($roleCreateUser);
        $entity->addRole($roleEditUser);
        $entity->addRole($roleDeleteUser);
        $entity->addRole($roleViewUser);
        $entity->addRole($roleChangepasswordUser);

        $entity->addRole($roleCreatePointofsale);
        $entity->addRole($roleEditPointofsale);
        $entity->addRole($roleDeletePointofsale);
        $entity->addRole($roleViewPointofsale);

        $entity->addRole($roleCreateAclrole);
        $entity->addRole($roleEditAclrole);
        $entity->addRole($roleDeleteAclrole);
        $entity->addRole($roleViewAclrole);

        $entity->addRole($roleCreateAclprofile);
        $entity->addRole($roleEditAclprofile);
        $entity->addRole($roleDeleteAclprofile);
        $entity->addRole($roleViewAclprofile);


        $manager->persist($entity);
        $this->addReference('profile-editor', $entity);


        $entity = new Profile();
        $entity->setName('Editor');
        $manager->persist($entity);

        $entity = new Profile();
        $entity->setName('Futbolista');
        $manager->persist($entity);

        $entity = new Profile();
        $entity->setName(Profile::GUEST);
        $entity->addRole($roleBackend);
        $manager->persist($entity);


        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}