<?php

namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;
use Contract\Entity\Contract;
use Zend\Http\Request;
use Zend\Authentication\Storage\Session as SessionStorage;
use Acl\Controller\IndexController as Role;

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
     * list of companies.
     */
    public function indexAction()
    {
        $ob = new Role();
        $ses = new SessionStorage();
        $user = $ses->read();

        if($ob->checkRole($user->getRoleId(), 'index')) {
            $contracts = $this->entityManager->getRepository(Contract::class)
                                            ->findBy([], ['id' => 'ASC']);
            return new ViewModel([
                'contracts' => $contracts,
                'newContract' => true
            ]);
        } else {
            $companies = $this->entityManager->getRepository(Contract::class)
                                            ->findBy(['userId' => $user->getId()], ['id' => 'ASC']);
            return new ViewModel([
                'contracts' => $companies,
                'newContract' => false
            ]);
        }
    }
}
