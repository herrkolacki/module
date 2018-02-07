<?php
namespace Dev\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Dev\Controller\MyController;

class MyControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        // Instantiate the controller and inject dependencies
        return new MyController($container);
    }
}