<?php

namespace Dev\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ConfigController extends AbstractActionController
{

    public $sm;

    public function __construct(ContainerInterface $sm)
    {

        $this->sm = $sm;

//\Zend\Debug\Debug::dump( $cos, __METHOD__.' ['.__LINE__ . ']' );
//\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );
//die( __METHOD__ . ' ' . __LINE__ );

    }

    public function indexAction()
    {

        $key = $this->params('key');
        $params = [
            'type' => 'array',
            'key' => $key
        ];
        $config = $this->getDevConfig($params);

        $view = new ViewModel([
            'key' => $key,
            'config' => $config,
        ]);
        return $view;

    }


    public function detailsAction()
    {

        //$this->getDevConfig();
        
        $key = $this->params('key');
        $params = [
            'type' => 'array',
            'key' => $key
        ];
        $config = $this->getDevConfig($params);


//\Zend\Debug\Debug::dump( $config, __METHOD__.' ['.__LINE__ . ']' . ' config: ' );
//\Zend\Debug\Debug::dump( $this->getRequest()->getServer('REMOTE_ADDR'), __METHOD__.' ['.__LINE__ . ']' . ' getServerParams(): ' );
//die(__METHOD__.' ['.__LINE__ . ']');

        $view = new ViewModel([
            'key' => $key,
            //'config' => $this->sm->get('config'),
            'config' => $config,
        ]);
        return $view;

    }

}