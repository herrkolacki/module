<?php

namespace ProductRepo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ProductRepo\Entity\ProductRepo;

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
     * list of ProductRepos.
     */
    public function indexAction()
    {
        $ProductRepos = $this->entityManager->getRepository(ProductRepo::class)
                                     ->findBy([], ['id'=>'ASC']);

        return new ViewModel([
            'ProductRepos' => $ProductRepos
        ]);
    }

    /**
     * This is the default "index" action of the controller. It displays the
     * list of ProductRepos.
     */
    public function offerAction()
    {

        $userId = 1;
        $ProductRepos = $this->entityManager->getRepository(ProductRepo::class)
                                        ->findBy(['user_id' => $userId], ['id'=>'ASC']);

        return new ViewModel([
            'ProductRepos' => $ProductRepos
        ]);
    }
}
