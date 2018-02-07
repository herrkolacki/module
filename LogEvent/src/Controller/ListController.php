<?php

namespace LogEvent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;
use LogEvent\Entity\LogEvent;
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
     * list of products.
     */
    public function indexAction()
    {

        $ob = new Role();

        $session = new SessionStorage();
        $user = $session->read();

        if(!$ob->checkRole($user->getRoleId(), 'index')){
            return $this->redirect()->toRoute('logout');
        }

        $logEvents = $this->entityManager->getRepository(LogEvent::class)
                                            ->findBy([], ['id' => 'ASC']);

         return new ViewModel([
                'logEvents' => $logEvents,
            ]);
    }

    /**
     * This is the default "index" action of the controller. It displays the
     * list of products.
     */
    public function offerAction()
    {

        $userId = 1;
        $products = $this->entityManager->getRepository(Product::class)
                                        ->findBy(['user_id' => $userId], ['id'=>'ASC']);

        return new ViewModel([
            'products' => $products
        ]);
    }



}
