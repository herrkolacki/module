<?php

namespace Dev;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

//use User\Service\AuthAdapter;

class Module implements ConfigProviderInterface
{

    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        //$eventManager = $app->getEventManager();

        $a = __FILE__;

//$app->getMvcEvent()->getRouteMatch();
//\Zend\Debug\Debug::dump( $event->getRouteMatch(), __METHOD__.' ['.__LINE__ . ']' . ', getRouteMatch: ' );
//die(__METHOD__.' ['.__LINE__ . ']');

        //$app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, function ($event) {
        $app->getEventManager()->attach(MvcEvent::EVENT_ROUTE, function ($event) {

            $routeMatch = $event->getRouteMatch();
 
//\Zend\Debug\Debug::dump( $routeMatch, __METHOD__.' ['.__LINE__ . ']' . ', routeMatch: ' );
//die(__METHOD__.' ['.__LINE__ . ']');

            /*
            if ($routeMatch->getParam('locale') != '') {
                $this->serviceManager = $e->getApplication()->getServiceManager();
                $translator = $this->serviceManager->get('translator');
                $translator->setLocale($routeMatch->getParam('locale'));
            }
            */

        });


        $sm = $app->getServiceManager();
        $dupa = $sm->get(\Dev\Service\Test::class);
//\Zend\Debug\Debug::dump( $dupa->getDupa(), __METHOD__.' ['.__LINE__ . ']' . ', getDupa: ' );
        $dupa->setDupa('Wielka DUPA');

    }

    /**
     * This method returns the path to module.config.php file.
     */
    public function getConfig()
    {

//die(__METHOD__.' ['.__LINE__ . ']');

        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [];
    }


}