<?php
namespace Product\Service;

use Product\Entity\Product;
use Zend\Math\Rand;
use Zend\Config\Factory;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class ProductManager
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
     * This method adds a new product.
     */
    public function addProduct($data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Project entity.
        $product = new Product();
        $product->setName($data['name']);
        $product->setInsurerId($data['insurer_id']);
        $product->setActive($data['active']);
        $product->setDescription($data['description']);
        $product->setAccessCode($data['access_code']);
        $product->setPrice($data['price']);
        $product->setCreated($currentDate);
        $product->setModified($currentDate);
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($product);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $product;
    }
    
    /**
     * This method updates data of an existing product.
     */
    public function updateProduct($product, $data)
    {
        $currentDate = date('Y-m-d H:i:s');
        $product->setName($data['name']);
        $product->setActive($data['active']);
        $product->setDescription($data['description']);
        $product->setModified($currentDate);
        $product->setPrice($data['price']);
        $this->entityManager->persist($product);
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
}

