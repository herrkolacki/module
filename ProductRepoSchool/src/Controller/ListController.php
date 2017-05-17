<?php

namespace ProductRepoSchool\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ProductRepoSchool\Entity\ProductRepoSchool;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class ListController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager;
    
    /**
     * Auth manager.
     * @var User\Service\AuthManager 
     */
    private $authManager;
    
    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;
    

    /**
     * Constructor.
     */
    public function __construct($entityManager, $authManager, $authService)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->authService = $authService;
    }


    /**
     * This is the default "index" action of the controller. It displays the
     * list of productRepos.
     */
    public function indexAction()
    {
        $productRepos = $this->entityManager->getRepository(ProductRepoSchool::class)
                                     ->findBy([], ['id'=>'ASC']);




        return new ViewModel([
            'productRepos' => $productRepos
        ]);
    }

    /**
     * This is the default "index" action of the controller. It displays the
     * list of productRepos.
     */
    public function offerAction()
    {

        $userId = 1;
        $productRepos = $this->entityManager->getRepository(ProductRepoSchool::class)
                                        ->findBy(['user_id' => $userId], ['id'=>'ASC']);

        return new ViewModel([
            'productRepos' => $productRepos
        ]);
    }
}
