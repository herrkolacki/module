<?php

namespace Dev\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class IndexController extends AbstractActionController
{

    /**
     * Constructor.
     */
    public function __construct($cos)
    {

//\Zend\Debug\Debug::dump( $cos, __METHOD__.' ['.__LINE__ . ']' );
//\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );
//die( __METHOD__ . ' ' . __LINE__ );

    }

    /**
     * This is the default "index" action of the controller. 
     */
    public function indexAction()
    {

//\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );
//die(__METHOD__.' ['.__LINE__ . ']');

        return new ViewModel();

    }

    public function tmpAction()
    {

//\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );
//die(__METHOD__.' ['.__LINE__ . ']');

    }

}