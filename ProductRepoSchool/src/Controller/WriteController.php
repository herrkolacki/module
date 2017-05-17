<?php
namespace ProductRepoSchool\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use ProductRepoSchool\Form\ProductRepoSchoolForm;
use ProductRepoSchool\Entity\ProductRepoSchool;


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
     * @var User\Service\productRepoSchoolManager
     */
    private $productRepoSchoolManager;
    
    private $authService;
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $productRepoSchoolManager, $authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->productRepoSchoolManager = $productRepoSchoolManager;
    }
    
    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        // Create user form
        $form = new ProductRepoSchoolForm('create', $this->entityManager);
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
                $productRepoSchool = $this->productRepoSchoolManager->addProductRepoSchool($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('productRepoSchool',
                        ['action'=>'view', 'id'=>$productRepoSchool->getId()]);
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


        $productRepoSchool = $this->entityManager->getRepository(ProductRepoSchool::class)
                ->find($id);


        if ($productRepoSchool == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Create user form
        $form = new productRepoSchoolForm('update', $this->entityManager, $productRepoSchool);

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
                $this->productRepoSchoolManager->updateProductRepo($productRepoSchool, $data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('productRepoSchool',
                        ['action'=>'view', 'id'=>$productRepoSchool->getId()]);
            }               
        } else {
            $form->setData(array(
                    'name'=>$productRepoSchool->getName(),
             ));
        }
        
        return new ViewModel(array(
            'productRepoSchool' => $productRepoSchool,
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
        $productRepoSchool = $this->entityManager->getRepository(ProductRepoSchool::class)
                                           ->find($id);

        if ($productRepoSchool == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'productRepo' => $productRepoSchool
        ]);
    }
    
}


