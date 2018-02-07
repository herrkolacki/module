<?php
namespace Contract\Service;

use Contract\Entity\Contract;


/**
 * This service is responsible for adding/editing Contract
 *
 */
class ContractManager
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
        $this->entityManager = $entityManager;
    }
    
    /**
     * This method adds a new Contract.
     */
    public function addContract($data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Company entity.
        $contract = new Contract();
        $contract->setUserId($data['userId']);
        $contract->setProductId($data['productId']);
        $contract->setCreated($currentDate);
        $contract->setPaymentId($data['paymentId']);
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($contract);
        
        // Apply changes to database.
        $this->entityManager->flush();
        return $contract;
    }
    
    /**
     * This method updates data of an existing product.
     */
    public function updateContract($contract, $data)
    {
        $currentDate = date('Y-m-d H:i:s');
        $contract->setUserId($data['userId']);
        $contract->setProductId($data['productId']);
        $contract->setCreated($currentDate);
        $contract->setPaymentId($data['paymentId']);

        $this->entityManager->persist($contract);
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
}

