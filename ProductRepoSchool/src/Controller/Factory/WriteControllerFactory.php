<?php
namespace ProductRepoSchool\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ProductRepoSchool\Controller\WriteController;
use ProductRepoSchool\Service\ProductRepoSchoolManager;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class WriteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $productRepoSchoolManager = $container->get(ProductRepoSchoolManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        // Instantiate the controller and inject dependencies
        return new WriteController($entityManager, $productRepoSchoolManager, $authService);
    }
}