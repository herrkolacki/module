<?php
namespace Product\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Product\Controller\ListController as Product;
use Product\Service\ProductManager;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class ListControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $productManager = $container->get(ProductManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        // Instantiate the controller and inject dependencies
        return new Product($entityManager, $productManager, $authService);
    }
}