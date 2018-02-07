<?php
namespace LogEvent\Service;

use LogEvent\Entity\LogEvent;
use Zend\Math\Rand;
use Zend\Config\Factory as Fac;
use Interop\Container\ContainerInterface;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class LogEventManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;  
    
    /**
     * Constructs the service.
     */
   public function __construct($entityManager)
    {
        $this->entityManager =  $entityManager;
    }

    /**
     * This method adds a new product.
     */
    public function addLogEvent($data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $logEvent = new LogEvent();

        $logEvent->setUserId($data['userId']);
        $logEvent->setCreated($currentDate);
        $logEvent->setIp($data['ip']);
        $logEvent->setAction($data['action']);
        $logEvent->setResult($data['result']);
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($logEvent);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $logEvent;
    }
    
    /**
     * This method updates data of an existing product.
     */
    public function updateLogEvent($logEvent, $data)
    {
        $currentDate = date('Y-m-d H:i:s');
        $logEvent->setUserId($data['userId']);
        $logEvent->setCreated($currentDate);
        $logEvent->setIp($data['ip']);
        $logEvent->setAction($data['action']);
        $logEvent->setResult($data['result']);
        $this->entityManager->persist($logEvent);
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
}

