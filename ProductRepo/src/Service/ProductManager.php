<?php
namespace ProductRepo\Service;

use ProductRepo\Entity\ProductRepo;
use Zend\Math\Rand;
use Zend\Config\Factory;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class ProductRepoManager
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
     * This method adds a new ProductRepo.
     */
    public function addProductRepo($data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $ProductRepo = new ProductRepo();
        $ProductRepo->setInsurerId($data['insurer_id']);
        $ProductRepo->setActive($data['active']);
        $ProductRepo->setDescription($data['description']);
        $ProductRepo->setAccessCode($data['access_code']);
        $ProductRepo->setCreated($currentDate);
        $ProductRepo->setModified($currentDate);
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($ProductRepo);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $ProductRepo;
    }
    
    /**
     * This method updates data of an existing ProductRepo.
     */
    public function updateProductRepo($ProductRepo, $data)
    {
        // Do not allow to change user email if another user with such email already exits.


        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $ProductRepo = new ProductRepo();
        $ProductRepo->setInsurerId($data['insurer_id']);
        $ProductRepo->setActive($data['active']);
        $ProductRepo->setDescription($data['description']);
        $ProductRepo->setAccessCode($data['access_code']);
        $ProductRepo->setModified($currentDate);

        
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
}

