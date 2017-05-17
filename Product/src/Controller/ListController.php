<?php

namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;
use Product\Entity\Product;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Authentication\Storage\Session as SessionStorage;

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
        $acl = new Acl();

        $roleGuest = new Role('4');
        $acl->addRole($roleGuest);
        $acl->addRole(new Role('1'), $roleGuest);


        $acl->addResource(new Resource('index'));

        $acl->deny('4', 'index');
        $acl->allow('1', 'index');


        $nowy = new SessionStorage();
        $role = $nowy->read();
        var_dump($role->getRoleId());
        if($acl->isAllowed($role->getRoleId(), 'index')){
            echo $acl->isAllowed('1', 'index') ? 'allowed' : 'denied';// tu sprawdzam czy ma prawo

            $products = $this->entityManager->getRepository(Product::class)
                                            ->findBy([], ['id' => 'ASC']);


            return new ViewModel([
                'products' => $products
            ]);
        }else{
            die('jesteś śmieciem');
        }
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
