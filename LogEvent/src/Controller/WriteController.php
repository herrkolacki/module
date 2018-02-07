<?php
namespace LogEvent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use LogEvent\Form\LogEventForm;
use LogEvent\Service\LogEventManager as Men;
//use User\Entity\User;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\Query\Expr;
use Doctrine\DBAL\Query\QueryBuilder;
use Zend\Authentication\Storage\Session as SessionStorage;
use Acl\Controller\IndexController as Role;

/**
 * This controller is responsible for user management (adding, editing, 
 * viewing users and changing user's password).
 */
class WriteController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * LogEvent manager.
     * @var LogEvent\Service\LogEventManager
     */
    private $logEventManager;
    
    private $authService;
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $logEventManager, $authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->logEventManager = $logEventManager;
    }
    
    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        $ob = new Role();
        $ss = new SessionStorage();
        $user = $ss->read();
        if($ob->checkRole($user->getRoleId(), 'add')){
        // Create user form
        $form = new LogEventForm('create', $this->entityManager);


        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();            

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Add product.
                $product = $this->logEventManager->addLogEvent($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('product',
                        ['action'=>'view', 'id'=>$product->getId()]);
            }               
        } 
        
        return new ViewModel([
                'form' => $form
            ]);
        } else {
            return $this->redirect()->toRoute('logout');
        }
    }
    
    /**
     * The "edit" action displays a page allowing to edit user.
     */
    public function editAction() 
    {
        $ob = new Role();
        $ss = new SessionStorage();
        $user = $ss->read();
        if(!$ob->checkRole($user->getRoleId(), 'edit')){
            return $this->redirect()->toRoute('logout');
        }
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }


        $product = $this->entityManager->getRepository(Product::class)
                ->find($id);

        $user = $this->entityManager->getRepository(User::class)
                                       ->find($id);

      //  var_dump($user);
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p.id as productId', 'u.id as userId', 'u.username', 'p.name', 'p.created as zombi', 'u.created as dupa')->from(User::class, 'u')->innerJoin(Product::class, 'p')->where('u.id = :userId')->setParameter('userId', 1);//->innerJoin(Product::class, 'p');
      //  var_dump($qb->getQuery()->getResult());



        if ($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Create user form

        $form = new ProductForm('update', $this->entityManager, $product);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            

            $form->setData($data);
            
            // Validate form
            if ($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                //var_dump($product);
                //var_dump($data); die();
                // Update the product
                $this->productManager->updateProduct($product, $data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('product',
                        ['action'=>'view', 'id'=>$product->getId()]);
            }               
        } else {
            $form->setData(array(
                    'name'=>$product->getName(),
             ));
        }
        
        return new ViewModel(array(
            'product' => $product,
            'form' => $form
        ));
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

        $query = $this->entityManager;



        if ($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $data = ['id' =>$product-> getId(), 'name' => $product->getName()];
        $productJson = new JsonModel($data); // tak mo¿na przekazywac jako obiekt
        var_dump($productJson);

        $jsonEncode = json_encode($data); // tak mo¿na przekazywaæ jako tablicê
        var_dump($jsonEncode);
        die();
        return $productJson;

        //return new ViewModel([
        //    'product' => $product
        //]);
    }
}


