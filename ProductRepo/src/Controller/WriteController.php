<?php
namespace ProductRepo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use ProductRepo\Form\ProductRepoForm;
use ProductRepo\Entity\ProductRepo;


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
     * @var User\Service\productRepoManager
     */
    private $productRepoManager;
    
    private $authService;
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $productRepoManager, $authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->productRepoManager = $productRepoManager;
    }
    
    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        // Create user form
        $form = new productRepoForm('create', $this->entityManager);
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

                // Add productRepo.
                $productRepo = $this->productRepoManager->addproductRepo($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('productRepo',
                        ['action'=>'view', 'id'=>$productRepo->getId()]);
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


        $productRepo = $this->entityManager->getRepository(productRepo::class)
                ->find($id);


        if ($productRepo == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Create user form
        $form = new productRepoForm('update', $this->entityManager, $productRepo);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            

            $form->setData($data);
            
            // Validate form
            if ($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();

                // Update the productRepo
                $this->productRepoManager->updateproductRepo($productRepo, $data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('productRepo',
                        ['action'=>'view', 'id'=>$productRepo->getId()]);
            }               
        } else {
            $form->setData(array(
                    'name'=>$productRepo->getName(),
             ));
        }
        
        return new ViewModel(array(
            'productRepo' => $productRepo,
            'form' => $form
        ));
    }

    /**
     * The "view" action displays a page allowing to view productRepo's details.
     */
    public function viewAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $productRepo = $this->entityManager->getRepository(productRepo::class)
                                           ->find($id);

        if ($productRepo == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'productRepo' => $productRepo
        ]);
    }
    
}


