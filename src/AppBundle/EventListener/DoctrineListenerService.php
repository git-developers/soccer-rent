<?php

namespace AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use AppBundle\Entity\Profile;
use AppBundle\Entity\PointOfSale;
use AppBundle\Entity\CategoryHasProduct;
use AppBundle\Entity\Product;
use AppBundle\Entity\Bet;
use AppBundle\Entity\Reserva;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// https://coderwall.com/p/es3zkw/symfony2-listen-doctrine-events

class DoctrineListenerService implements EventSubscriber
{

    protected $container;
    protected $dateTime;
    protected $tokenStorage;
    protected $active;
    protected $uniqid;

    public function __construct(ContainerInterface $container, TokenStorage $tokenStorage)
    {
        $this->container = $container;
        $this->dateTime = new \DateTime();
        $this->tokenStorage = $tokenStorage;
        $this->active = true;
        $this->uniqid = uniqid();
    }

    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'preUpdate',
            'prePersist',
            'preRemove',
            'preFlush',
            'postFlush',
            'postPersist',
            'postUpdate',
            'postRemove',
            'postLoad',
            'onFlush',
        ];
    }

    /**
     * This method will called on Doctrine postPersist event
     */
    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
//        $className = $entityManager->getClassMetadata(get_class($entity))->getName();

        if ($entity instanceof User){
//            $name = $this->name($entity->getEmail());
//            $entity->setName(uniqid());
//            $name = $entity->getName();

            $plainPassword = $entity->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($entity, $plainPassword);
            $entity->setPassword($encoded);

            $entity->setUsername(uniqid());
            $entity->setUsernameCanonical(uniqid());
//            $entity->setSlug($this->makeSlug($this->uniqid, $name, 90));
            $entity->setCreatedAt($this->dateTime);
            $entity->setIsActive($this->active);
            $entity->setEnabled($this->active);
//            $entity->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            return;
        }else if ($entity instanceof Profile){

            $name = $entity->getName();
            $entity->setSlug($this->makeSlug($name, 90));

            $entity->setCreatedAt($this->dateTime);

            return;
        }else if ($entity instanceof Role){

            $entity->setCreatedAt($this->dateTime);

            return;
        }else if ($entity instanceof PointOfSale){
            $name = $entity->getName();
            $entity->setSlug($this->makeSlug($name, 90));
            $entity->setCreatedAt($this->dateTime);

            return;
        }else if ($entity instanceof Product){
            $name = $entity->getName();
            $entity->setSlug($this->makeSlug($name, 90));
            $entity->setCreatedAt($this->dateTime);

            return;
        }else if ($entity instanceof CategoryHasProduct){
            $entity->setCreatedAt($this->dateTime);

            return;
        }else if ($entity instanceof Bet){
            $entity->setCreated($this->dateTime);
            $entity->setActive(1);

            return;
        }else if ($entity instanceof Reserva){
            $entity->setCreatedAt($this->dateTime);
            $entity->setIsActive(1);

            return;
        }
    }

    /**
     * This method will called on Doctrine postPersist event
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
//        $className = $entityManager->getClassMetadata(get_class($entity))->getName();

        if ($entity instanceof User){
//            $entity->setLastAccess($this->dateTime);
            $entity->setUpdatedAt($this->dateTime);

//            if ($entity->hasChangedField('image')) {
//                // Do something when the username is changed.
//            }

            return;
        }
    }

    /**
     * This method will called on Doctrine postUpdate event
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof User){

            return;
        }
    }

    /**
     * This method will called on Doctrine postRemove event
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof User){
            $entity->setUpdatedAt($this->dateTime);
            return;
        }
    }

    /**
     * This method will called on Doctrine postLoad event
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof User){

            $fileName = $entity->getImage();

            if(!is_null($fileName)){
                $entity->setImageFilter($fileName);
            }

            return;
        }

    }

    private function makeSlug($string, $length = 100)
    {
        $slug = $this->slugify($string);
        return substr($slug, 0, $length);
//        $slug = substr($slug, 0, $length);
//        return $uniqid.'-'. $slug;
    }

    private function slugify($string, $separator = '-')
    {
        $slugify = new Slugify(['lowercase' => true, 'separator' => $separator, 'ruleset' => 'default']);
        return $slugify->slugify($string);
    }

    private function name($email)
    {
        try{
            list($name, $domain) = explode('@', trim($email));
            return preg_replace('/[0-9]+/', '', $this->slugify($name, ''));
        }catch (\Exception $e){
            return $this->uniqid;
        }
    }

}






