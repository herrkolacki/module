<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contract\Form\ContractForm;
use Contract\Entity\Contract;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\Query\Expr;
use Zend\Authentication\Storage\Session as SessionStorage;
use Acl\Controller\IndexController as Role;

/**
 * This controller is responsible for company management (adding, editing,
 * viewing).
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
    private $companyManager;
    
    private $authService;
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $companyManager, $authService)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->companyManager = $companyManager;
    }
    
    /**
     * This action displays a page allowing to add a new company.
     */
    public function addAction()
    {
        $role = new Role();
        $ses = new SessionStorage();
        $user = $ses->read();
        if($role->checkRole($user->getRoleId(), 'add')){
        // Create user form
        $form = new ContractForm('create', $this->entityManager);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();            

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Add company
                $contract = $this->contractManager->addContract($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('contract',
                        ['action'=>'view', 'id'=>$contract->getId()]);
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
        $ses = new SessionStorage();
        $user = $ses->read();
        if(!$ob->checkRole($user->getRoleId(), 'edit')){
            return $this->redirect()->toRoute('logout');
        }
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $contract = $this->entityManager->getRepository(Contract::class)
                ->find($id);


        if ($contract == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $form = new ContractForm('update', $this->entityManager, $contract);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            $form->setData($data);
            
            // Validate form
            if ($form->isValid()) {
                
                $data = $form->getData();

                // Update the company
                $this->contractManager->updateContract($contract, $data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('Contract',
                        ['action'=>'view', 'id'=>$contract->getId()]);
            }               
        } else {
            $form->setData(array(
                    'name'=>$contract->getName(),
             ));
        }
        
        return new ViewModel(array(
            'contract' => $contract,
            'form' => $form
        ));
    }
    /**
     * The "view" action displays a page allowing to view company details.
     */
    public function viewAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);

        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a company with such ID.
        $contract = $this->entityManager->getRepository(Contract::class)
                                       ->find($id);

        if ($contract == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $data = ['id' =>$contract-> getId(), 'name' => $contract->getName()];
        $contractJson = new JsonModel($data); // tak można przekazywac jako obiekt
        var_dump($contractJson);

        $jsonEncode = json_encode($data); // tak można przekazywać jako tablicć
        var_dump($jsonEncode);
        die();
        return $productJson;

    }
}


