<?php
namespace Dev\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Dev\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


//die( __METHOD__ . ' ' . __LINE__ );

        //$productManager = $container->get(ProductManager::class);
        $dependency = 'COS';

        // Instantiate the controller and inject dependencies
        return new IndexController($dependency);
    }
}