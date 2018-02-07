<?php

namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;
use Product\Entity\Product;
use User\Entity\User;
use Zend\Http\Request;
use User\Service\UserManager;
use Zend\Authentication\Storage\Session as SessionStorage;
use Acl\Controller\IndexController as Role;
use Zend\View\Model\JsonModel;

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

    private $user;

    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    private $acl;

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
    public function indexAction(){

        var_dump($this->user); die();

        $ob = new Role();

        $ob->addPermission(3, 'index'); // dodaje upraweniena do roli
        if($this->user){
            if($ob->checkRole($this->user->getRoleId(), 'index')){

                $products = $this->entityManager->getRepository(Product::class)
                                                ->findBy([], ['id' => 'ASC']);

                $jsonProduct = new JsonModel([
                    'products' => $products,
                    'newProduct' => true
                ]);
                return $jsonProduct;
            }else{
                $products = (array)$this->entityManager->getRepository(Product::class)
                                                       ->findBy(['userId' => $this->user->getId()], ['id' => 'ASC']);

                //  $jsonEncode = json_encode($products);

                // return $jsonEncode;

                $jsonProduct = new JsonModel([
                    'products' => $products,
                    'newProduct' => false,

                ]);
                return $jsonProduct;
            }
        }else{
            $products = $this->entityManager->getRepository(Product::class)
                                            ->findBy([], ['id' => 'ASC']);

            $jsonProduct = new JsonModel([
                'products' => $products,
                'newProduct' => true
            ]);
            return $jsonProduct;
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
