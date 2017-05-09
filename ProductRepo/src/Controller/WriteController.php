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
     * @var User\Service\ProductRepoManager
     */
    private $ProductRepoManager;
    
    private $authService;
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $ProductRepoManager, $authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->ProductRepoManager = $ProductRepoManager;
    }
    
    /**
     * This action displays a page allowing to add a new user.
     */
    public function addAction()
    {
        // Create user form
        $form = new ProductRepoForm('create', $this->entityManager);
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

                // Add ProductRepo.
                $ProductRepo = $this->ProductRepoManager->addProductRepo($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('ProductRepo',
                        ['action'=>'view', 'id'=>$ProductRepo->getId()]);
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


        $ProductRepo = $this->entityManager->getRepository(ProductRepo::class)
                ->find($id);


        if ($ProductRepo == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Create user form
        $form = new ProductRepoForm('update', $this->entityManager, $ProductRepo);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            

            $form->setData($data);
            
            // Validate form
            if ($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();

                // Update the ProductRepo
                $this->ProductRepoManager->updateProductRepo($ProductRepo, $data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('ProductRepo',
                        ['action'=>'view', 'id'=>$ProductRepo->getId()]);
            }               
        } else {
            $form->setData(array(
                    'name'=>$ProductRepo->getName(),
             ));
        }
        
        return new ViewModel(array(
            'ProductRepo' => $ProductRepo,
            'form' => $form
        ));
    }

    /**
     * The "view" action displays a page allowing to view ProductRepo's details.
     */
    public function viewAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $ProductRepo = $this->entityManager->getRepository(ProductRepo::class)
                                           ->find($id);

        if ($ProductRepo == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'ProductRepo' => $ProductRepo
        ]);
    }
    
}


