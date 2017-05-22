<?php
namespace Acl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Permissions\Acl\Acl;
use Zend\Http\Request;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * This is the main controller class of the User Demo application. It contains
 * site-wide actions such as Home or About.
 */
class IndexController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $acl;
    
    /**
     * Constructor. Its purpose is to inject dependencies into the controller.
     */
    public function __construct()
    {
        $this->acl = new Acl();

        $roleGuest = new Role('4');
        $this->acl->addRole($roleGuest);
        $this->acl->addRole(new Role('1'), $roleGuest);
        $this->acl->addResource(new Resource('index'));
        $this->acl->addResource(new Resource('add'));
        $this->acl->addResource(new Resource('view'));
        $this->acl->addResource(new Resource('edit'));
       // $this->acl->deny('4', 'index');
        $this->acl->allow('1', 'index');
    }
    
    public function checkRole($role, $resource){
        if($this->acl->isAllowed($role, $resource)){
            return true;
        }
        return false;
    }

    public function addPermission($role, $resource){
       // $this->acl->addResource($resource);
        $this->acl->allow($role, $resource);
    }


    public function deletePermission($role, $resource){
       // $this->acl->addResource($resource);
        $this->acl->deny($role, $resource);
    }

}

