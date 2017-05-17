<?php
namespace ProductRepoSchool\Service;

use ProductRepoSchool\Entity\ProductRepoSchool;
use Zend\Math\Rand;
use Zend\Config\Factory;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class ProductRepoSchoolManager
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
    public function addProductRepoSchool($data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $productRepoSchool = new ProductRepoSchool();

        $productRepoSchool->setActive($data['active']);
        $productRepoSchool->setCreated($currentDate);
        $productRepoSchool->setComment($data['comment']);
        $productRepoSchool->setProductRepoId($data['product_repo_id']);

        // Add the entity to the entity manager.
        $this->entityManager->persist($productRepoSchool);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $productRepoSchool;
    }
    
    /**
     * This method updates data of an existing productRepo.
     */
    public function updateProductRepoSchool($productRepoSchool, $data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $productRepoSchool->setCreated($currentDate);
        $productRepoSchool->setComment($data['comment']);
        $productRepoSchool->setProductRepoId($data['product_repo_id']);


        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
}

