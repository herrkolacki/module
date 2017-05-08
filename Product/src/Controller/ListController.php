<?php

namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Entity\Product;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

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

        $roleGuest = new Role('guest');
        $acl->addRole($roleGuest);
        $acl->addRole(new Role('staff'), $roleGuest);
        $acl->addRole(new Role('editor'), 'staff');
        $acl->addRole(new Role('administrator'));




       // $acl->addRole(new Role('someUser'), $parents);

        $acl->addResource(new Resource('index'));

        $acl->deny('staff', 'index');
        $acl->allow('editor', 'index');

        echo $acl->isAllowed('staff', 'index') ? 'allowed' : 'denied';

        $products = $this->entityManager->getRepository(Product::class)
                                     ->findBy([], ['id'=>'ASC']);

        return new ViewModel([
            'products' => $products
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

    /**
     * The "view" action displays a page allowing to view product's details.
     */
    public function viewAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $product = $this->entityManager->getRepository(Product::class)
                                    ->find($id);

        if ($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'product' => $product
        ]);
    }

}
