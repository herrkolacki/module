<?php

namespace Dev\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class MyController extends AbstractActionController
{

    protected $sm;

    /**
     * Constructor.
     */
    public function __construct(ContainerInterface $sm)
    {
    
        $this->sm = $sm;

//\Zend\Debug\Debug::dump( $cos, __METHOD__.' ['.__LINE__ . ']' );
//\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );
//die( __METHOD__ . ' ' . __LINE__ );

    }


    /**
     * This is the default "index" action of the controller. 
     */
    public function indexAction()
    {

//\Zend\Debug\Debug::dump($this->getEvent()->getRouteMatch() , __METHOD__.' ['.__LINE__ . ']' );
//die(__METHOD__.' ['.__LINE__ . ']');

        $view = new ViewModel([]);
        return $view;

    }

    public function ipAction()
    {

//\Zend\Debug\Debug::dump( $this->getRequest()->getUri(), __METHOD__.' ['.__LINE__ . ']' . ' getUri(): ' );
//die(__METHOD__.' ['.__LINE__ . ']');

        $view = new ViewModel([
            'success' => '1', 
            //'ip' => $this->getRequest()->getServer('REMOTE_ADDR'), 
            'request' => $this->getRequest(),
            'response' => $this->getResponse()
        ]);
        return $view;

    }

}