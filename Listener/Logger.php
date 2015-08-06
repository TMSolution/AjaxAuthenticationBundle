<?php

namespace Core\AjaxAuthenticationBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use TMSolution\OwcaBundle\Entity\Calculation;

class Logger {

    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * Add log after insert
     * @author Łukasz Wawrzyniak <lukasz.wawrzyniak@tmsolution.pl>
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @see \TMSolution\LoggingBundle\EntityLogger
     */
    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $logManager = $this->container->get('TMSolution.Logging.EntityLogger');
        if ($entity instanceof Calculation) {

            $logManager->addCreateOperation($entity, "",array(), $logManager::DEBUG);
        }
    }

    /**
     * Add log before update
     * @author Łukasz Wawrzyniak <lukasz.wawrzyniak@tmsolution.pl>
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @see \TMSolution\LoggingBundle\EntityLogger
     */
    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        /*
          $em = $this->container->get('doctrine')->getManager();
          $uow = $em->getUnitOfWork();
          $uow->computeChangeSets(); // do not compute changes if inside a listener
          $changeset = $uow->getEntityChangeSet($entity);

          $extendedMsg = '';
         */

        $logManager = $this->container->get('TMSolution.Logging.EntityLogger');

        if ($entity instanceof Calculation) {
            $logManager->addUpdateOperation($entity, "", array(), $logManager::DEBUG);
        }
    }

}
