<?php
namespace Company\Service;

use Company\Entity\Company;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class CompanyManager
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
     * This method adds a new company.
     */
    public function addProduct($data)
    {
        $currentDate = date('Y-m-d H:i:s');
        // Create new Company entity.
        $company = new Company();
        $company->setName($data['name']);
        $company->setInsurerId($data['userId']);
        $company->setNip($data['nip']);
        $company->setCreated($currentDate);
        $company->setModified($currentDate);
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($company);
        
        // Apply changes to database.
        $this->entityManager->flush();
        return $company;
    }
    
    /**
     * This method updates data of an existing product.
     */
    public function updateProduct($company, $data)
    {
        $currentDate = date('Y-m-d H:i:s');
        $company->setName($data['name']);
        $company->setInsurerId($data['userId']);
        $company->setNip($data['nip']);
        $company->setCreated($currentDate);
        $company->setModified($currentDate);

        $this->entityManager->persist($company);
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
}

