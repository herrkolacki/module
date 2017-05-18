<?php

namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;
use Product\Entity\Product;

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
    public function indexAction()
    {

        $ob = new Role();

        header('Authorization: Basic '.'232432423');
        $nowy = new SessionStorage();
        $role = $nowy->read();
        var_dump($role->getRoleId());

        $request = new Request();
       // $request->setMethod(Request::METHOD_POST);
        $request->getHeaders()->addHeaders(['Authenticate' => 'Negotiate']);
        $ob->addPermission(4,'index');
        var_dump($_SERVER);
        var_dump($request->getHeaders('Authorization'));
        var_dump($request->getHeaders('Authenticate'));
        var_dump(apache_response_headers());

        if($ob->checkRole($role->getRoleId(), 'index')){


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
