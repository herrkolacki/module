<?php
namespace Dev\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
//use Zend\Mvc\Service\AbstractPluginManagerFactory;

//use Zend\Mvc\Controller\Plugin\PluginInterface;

//use Dev\Controller\MyController;

//class ConfigControllerFactory implements AbstractPluginManagerFactory
//class TestyFactory implements PluginInterface
class TestyFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

//\Zend\Debug\Debug::dump( $config ); 
//die(__METHOD__);

        return new Testy($container);
        
    }
}