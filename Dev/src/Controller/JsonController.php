<?php

namespace Dev\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class JsonController extends AbstractActionController
{

    public $sm;

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

    public function indexAction()
    {


        $view = new JsonModel([
            'description' => 'przykład zwracania danych w formacie JSON z headerami, w resources inne zasoby(linki) tego controllera', 
            'resources' => [
                'actions' => [
                    'index' => '/dev/json', 
                    'ip'    => '/dev/json/ip', 
                ],
            ],
            'method' => __METHOD__,
            'success' => '1', 
        ]);
        return $view;

    }


    public function ipAction()
    {

//\Zend\Debug\Debug::dump( $this->getRequest()->getUri(), __METHOD__.' ['.__LINE__ . ']' . ' getUri(): ' );
//\Zend\Debug\Debug::dump( $this->getRequest()->getServer('REMOTE_ADDR'), __METHOD__.' ['.__LINE__ . ']' . ' getServerParams(): ' );
//die(__METHOD__.' ['.__LINE__ . ']');

        $view = new JsonModel([
            'description' => 'ta akcja zwraca IP w formacie JSON', 
            'ip' => $this->getRequest()->getServer('REMOTE_ADDR'), 
            'method' => __METHOD__,
            'success' => '1', 
        ]);
        return $view;

    }

}