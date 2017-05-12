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
     * This method adds a new productRepo.
     */
    public function addProductRepo($data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $productRepo = new ProductRepo();

        $productRepo->setActive($data['active']);
        $productRepo->setCreated($currentDate);
        $productRepo->setType($data['type']);
        $productRepo->setName($data['name']);

        // Add the entity to the entity manager.
        $this->entityManager->persist($productRepo);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $productRepo;
    }
    
    /**
     * This method updates data of an existing productRepo.
     */
    public function updateProductRepo($productRepo, $data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $productRepo->setActive($data['active']);
        $productRepo->setCreated($currentDate);
        $productRepo->setType($data['type']);
        $productRepo->setName($data['name']);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
}

