<?php
namespace Contract\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Contract\Controller\WriteController;
use Contract\Service\ContractManager;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class WriteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $contractManager = $container->get(ContractManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        // Instantiate the controller and inject dependencies
        return new WriteController($entityManager, $contractManager, $authService);
    }
}