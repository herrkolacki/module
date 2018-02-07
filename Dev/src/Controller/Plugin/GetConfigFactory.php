<?php
namespace Dev\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
//use Zend\Mvc\Service\AbstractPluginManagerFactory;

//use Dev\Controller\MyController;

//class ConfigControllerFactory implements AbstractPluginManagerFactory
class GetConfigFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

//\Zend\Debug\Debug::dump( $config ); 
//die(__METHOD__);

        return new GetConfig($config);
        
    }
}