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

        $roleKlient = new Role('4');
        $roleAgent = new Role('3');
        $roleOpiekun = new Role('2');
        $roleAdmin = new Role('1');
        $this->acl->addRole($roleKlient);
        $this->acl->addRole($roleAgent, $roleKlient);
        $this->acl->addRole($roleOpiekun,$roleAgent);
        $this->acl->addRole($roleAdmin, $roleOpiekun);
        $this->acl->addResource(new Resource('index'));
        $this->acl->addResource(new Resource('add'));
        $this->acl->addResource(new Resource('view'));
        $this->acl->addResource(new Resource('edit'));
        $this->acl->deny('4', 'index');
        $this->acl->allow('1', ['index', 'add', 'edit', 'view']);
        //$this->acl->allow('1', 'add');

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

