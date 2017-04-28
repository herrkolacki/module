<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Product\Form\ProductForm;


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
     * User manager.
     * @var User\Service\ProductManager
     */
    private $productManager;
    
    private $authService;
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $productManager, $authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->productManager = $productManager;
    }
    
    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        // Create user form
        $form = new ProductForm('create', $this->entityManager);
        $request = new Request();

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
                $product = $this->Manager->addProduct($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('product',
                        ['action'=>'view', 'id'=>$product->getId()]);
            }               
        } 
        
        return new ViewModel([
                'form' => $form
            ]);
    }
    
    /**
     * The "edit" action displays a page allowing to edit user.
     */
    public function editAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $product = $this->entityManager->getRepository(Product::class)
                ->find($id);
        
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
    
}


